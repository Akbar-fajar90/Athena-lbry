<?php

namespace App\Filament\Resources\Returns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Loans;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater;
use App\Models\LoanDetails;
use Illuminate\Support\Carbon;
class ReturnsForm
{
    public static function configure(Schema $schema): Schema
    {
        $isAdmin=Auth::user()?->role==="admin";
        return $schema
            ->components([
                Select::make('loan_id')
                    ->relationship(
                        'Loan', 
                        'id', 
                        fn(Builder $query) => $query
                        ->whereIn('status',['approved'])
                            ->when(!$isAdmin, fn($q)=>$q->where('user_id', Auth::id())
                            )
                        )
                        ->getOptionLabelFromRecordUsing(fn(Loans $record)=> "Peminjam {$record->id} -". ($record->user?->name))
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(fn(Get $get, Set $set)=> self::calculatingFine($get, $set))
                        ->preload()
                    ->required(),
                Select::make('received_by')
                    ->options(fn()=> \App\Models\User::pluck('name', 'id'))
                    ->default(fn()=>!$isAdmin? Auth::id():null)
                    ->hidden(!$isAdmin),
                DatePicker::make('return_date')
                    ->label('Tanggal Kembali')
                    ->required()
                    ->default(now())
                    ->live(),

                Repeater::make('returnItems')
                ->label('Buku Yang Dikembalikan')
                ->relationship('returnItems')
                ->schema([
                    select::make('book_id')
                    ->label('buku')
                    ->options(fn(Get $get)=> LoanDetails::where('loan_id', $get('../../loan_id'))
                    ->whereDoesntHave('returnItems')
                    ->with('books')
                    ->get()
                    ->pluck('books.title','id')
                    ->toArray()
                    )
                    ->searchable()
                    ->distinct()
                    ->required(),

                    TextInput::make('qty')
                    ->label('jumlah')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
                
                
                Select::make('status')   
                    ->label('Kondisi Buku')
                    ->options(['good' => 'Good', 'damaged' => 'Damaged', 'lost' => 'Lost'
                    ])
                    ->default('good')
                    ->required()
                    ->dehydrated()
                    ->hidden(!$isAdmin),
                TextInput::make('fine')
                    ->required()
                    ->numeric()
                    ->prefix('Rp.')
                    ->default(0)
                    ->hidden(!$isAdmin)
                    ->dehydrated(),

                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->addActionLabel('Tambah Buku')
            ]);
    }

    private static function calculatingFine(Get $get, Set $set): void
    {
        $loan = Loans::find($get('loan_id'));
        $date = $get('return_date');

        if(!$loan || !$date) return;

        $daysLate = max(0, Carbon::parse($loan->due_date)->diffInDays(Carbon::parse($date), false));

        $fine = $daysLate*1000;

        foreach($get('returnItems')?? []as $key => $item)
            {
            $set("returnItems.{$key}.fine", $fine);
        }
    }
}

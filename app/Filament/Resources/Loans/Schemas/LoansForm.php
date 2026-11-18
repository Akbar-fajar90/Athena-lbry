<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Carbon;

class LoansForm
{
    public static function configure(Schema $schema): Schema
    {
        $isAdmin = Auth::user() ?-> role ==='admin';
        return $schema
            ->components([
                Select::make('procced_by')
                ->options(fn()=> \App\Models\User::pluck('name', 'id'))
                // ->default(fn()=>Auth::id())
                ->preload()
                ->searchable()
                ->hidden(!$isAdmin)
                // ->dehydrated()
                // ->dehydrateStateUsing(fn($state)=> !$isAdmin ? Auth::id():$state),
                ,
                DatePicker::make('loan_date')
                    ->required()
                    ->default(now())
                    ->live()
                    ->afterStateUpdated(function(Set $set, $state){
                        $set('due_date', $state ? Carbon::parse($state)->addDays(7)->format('Y-m-d'):null);
                    })
                    ,
                DatePicker::make('due_date')
                    ->required()
                    ->default(fn()=>now()->addDays(7))
                    ->required()
                    ->readOnly()
                    ,
                Select::make('status')
                    ->options(['proccessed' => 'Proccessed', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('proccessed')
                    ->required()
                    
                    ->disabled(!$isAdmin),
                Repeater::make('LoanDetails')
                ->relationship()
                ->label('Buku Yang Dipinjam')
                ->schema([
                    Select::make('book_id')
                    ->label('Buku')
                    ->relationship('Books', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                    TextInput::make('qty')
                    ->label('Jumlah')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->defaultItems(1)
                ->addActionLabel('Tambah buku lain'),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}

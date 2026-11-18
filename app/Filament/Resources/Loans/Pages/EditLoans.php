<?php

namespace App\Filament\Resources\Loans\Pages;

use App\Filament\Resources\Loans\LoansResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\Books;    

class EditLoans extends EditRecord
{
    protected static string $resource = LoansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if($this->record->status==='approved'){
            $loanDetails = $this->record->loanDetails;
        }

        foreach ($loanDetails as $detail){
            $book = Books::find($detail->book_id);
        }

        $book->decrement('available_stock', $detail->qty);
    }
}

<?php

namespace App\Filament\Resources\Loans\Pages;

use App\Filament\Resources\Loans\LoansResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Books;

class CreateLoans extends CreateRecord
{
    protected static string $resource = LoansResource::class;

    protected function afterCreate(): void
    {
        
        $loanDetails = $this->record->loanDetails();

        foreach ($loanDetails as $detail) {
            $book = Books::find($detail->book_id);
            if($book){
                $book->decrement('available_stock', $detail->qty);
            }
    }
}
}

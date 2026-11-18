<?php

namespace App\Filament\Resources\Loans\RelationManagers;

use App\Filament\Resources\Loans\LoansResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class LoanDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'loanDetails';

    protected static ?string $relatedResource = LoansResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

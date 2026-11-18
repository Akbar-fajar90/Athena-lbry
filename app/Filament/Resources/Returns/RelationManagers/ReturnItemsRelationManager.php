<?php

namespace App\Filament\Resources\Returns\RelationManagers;

use App\Filament\Resources\Returns\ReturnsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ReturnItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'ReturnItems';

    protected static ?string $relatedResource = ReturnsResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

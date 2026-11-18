<?php

namespace App\Filament\Resources\Returns\Pages;

use App\Filament\Resources\Returns\ReturnsResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ReturnItems;
use Illuminate\Http\Request;

class CreateReturns extends CreateRecord
{
    protected static string $resource = ReturnsResource::class;

    // public function storeItems(Request $request): void
    // {
    //     $validated = $request->validated([
    //         'book_id'=>['required', 'exist:book_id'],
    //         'qty'=>['required', 'integer', 'min:1'],
    //     ]); 

    //     ReturnItems::create([
    //         'book_id'=>$validated['book_id'],
    //         'qty'=>$validated['qty'],
    //     ]);
    // }
}

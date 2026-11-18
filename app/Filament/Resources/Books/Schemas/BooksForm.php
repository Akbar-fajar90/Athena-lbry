<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class BooksForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->required()
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                        ->required()   
                        ->label('Kategori')
                        ->unique('categories', 'name')
                    ]),
                TextInput::make('title')
                ->label('Judul Buku')
                ->placeholder('Bumi Manusia')
                    ->required(),
                TextInput::make('isbn')
                    ->required()
                    ->label('ISBN')
                    ->placeholder('012-345-678'),
                TextInput::make('author')
                ->label('Author')
                    ->required()
                    ->placeholder('Pramoedya Ananta Toer'),
                TextInput::make('publisher')
                    ->required()
                    ->label('Publisher')
                    ->placeholder('Gramedia'),
                DatePicker::make('publish_year')
                    ->format('Y')
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->directory('books')
                    ->disk('public')
                    ->required(),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('available_stock')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}

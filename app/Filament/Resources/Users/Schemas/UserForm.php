<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->placeholder('Budi')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->placeholder('Budi@example.com')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->options(['admin' => 'Admin', 'siswa' => 'Siswa'])
                    ->default('siswa')
                    ->required(),
                TextInput::make('nisn')
                ->maxLength(10),
                Select::make('kelas')
                    ->options(['X' => 'X', 'XI' => 'XI', 'XII' => 'XII']),
                Select::make('jurusan')
                    ->options(['PPLG' => 'PPLG', 'TKR' => 'TKR', 'TKJ' => 'TKJ', 'KI' => 'KI', 'TEI' => 'TEI']),
                Select::make('jenis_kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan']),
                TextInput::make('no_telpon')
                    ->tel()
                    ->label('Telepon')
                    ->placeholder('08123XXX')
                    ->maxLength(20)
                    ->minLength(10),
                Textarea::make('alamat')
                    ->columnSpanFull()
                    ->label('Alamat')
                    ->placeholder('Jl. Joko Tingkir no. 90'),
                Toggle::make('isActive')
                    ->required(),
            ]);
    }
}

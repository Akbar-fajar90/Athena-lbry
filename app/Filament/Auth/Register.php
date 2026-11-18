<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Register as BaseRegister;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Register extends BaseRegister
{
    // protected string $view = 'filament.pages.auth.register';

    public function form(Schema $schema): Schema
    {
        $isAdmin = Auth::user() ?-> role ==='admin';
        return $schema
            ->components([
                // $this->getPasswordFormComponent(),
                // $this->getPasswordResetFormComponent(),
                // $this->getEmailFormComponent(),
                //  $this->getFormContentComponent(),

                TextInput::make('name')
                     ->required(),
                 TextInput::make('email')
                     ->label('Email address')
                    ->placeholder('budi@example.com')
                     ->email()
                     ->required(),
                 DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                     ->required(),
                Select::make('role')
                    ->options(['admin' => 'Admin', 'siswa' => 'Siswa'])
                    ->default('siswa')
                    ->hidden(!$isAdmin)
                    ->required(),
                TextInput::make('nisn')
                ->required(),
                Select::make('kelas')
                    ->options(['X' => 'X', 'XI' => 'XI', 'XII' => 'XII'])
                    ->required(),
                Select::make('jurusan')
                    ->options(['PPLG' => 'PPLG', 'TKR' => 'TKR', 'TKJ' => 'TKJ', 'KI' => 'KI', 'TEI' => 'TEI']),
                Select::make('jenis_kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                    ->required(),
                TextInput::make('no_telpon')
                ->label('No Telpon')
                ->placeholder('08123xxx')
                    ->tel()
                    ->required(),
                Textarea::make('alamat')
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('isActive')
                    ->default(true)
                    ->hidden(),
            ]);
    }
}

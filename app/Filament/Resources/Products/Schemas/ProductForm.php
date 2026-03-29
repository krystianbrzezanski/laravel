<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nazwa produktu')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($set, ?string $state) {
                        $set('slug', Str::slug($state));
                    }),
                
                TextInput::make('slug')
                    ->label('Slug (Link)')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('category_id')
                    ->label('Kategoria')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),

                TextInput::make('price')
                    ->label('Cena netto')
                    ->numeric()
                    ->required(),

                TextInput::make('stock')
                    ->label('Magazyn')
                    ->numeric()
                    ->default(0),

                FileUpload::make('image')
                    ->label('Zdjęcie produktu')
                    ->image() 
                    ->directory('images') // Zmienione z 'products' na 'images', aby trafiało do Twojego folderu public/images
                    ->visibility('public')
                    ->preserveFilenames(), // Zachowuje oryginalną nazwę pliku, np. lalka.jpg
            ])
            ->statePath('data');
    }
}
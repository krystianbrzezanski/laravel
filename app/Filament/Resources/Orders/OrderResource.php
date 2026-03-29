<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists\Infolist;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $recordTitleAttribute = 'customer_name';

    // Ta metoda zostaje, bo build ją akceptuje
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Szczegóły zamówienia')
                    ->schema([
                        \Filament\Schemas\Components\TextEntry::make('customer_name')->label('Klient'),
                        \Filament\Schemas\Components\TextEntry::make('total_price')->label('Suma'),
                    ]),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Klient'),
                Tables\Columns\TextColumn::make('total_price')->label('Suma'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->actions([
                // CAŁKOWICIE PUSTE AKCJE - to musi wyeliminować błąd "Class not found"
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }
}
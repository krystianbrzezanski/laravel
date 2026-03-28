<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $recordTitleAttribute = 'customer_name';

    // W Twojej wersji 'infolist' również używa klasy Schema zamiast Infolist
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Szczegóły zamówienia')
                    ->columns(2)
                    ->components([
                        \Filament\Schemas\Components\TextEntry::make('customer_name')->label('Klient'),
                        \Filament\Schemas\Components\TextEntry::make('email')->label('Email'),
                        \Filament\Schemas\Components\TextEntry::make('status'),
                        \Filament\Schemas\Components\TextEntry::make('total_price')->label('Suma'),
                    ]),

                \Filament\Schemas\Components\Section::make('Produkty')
                    ->components([
                        \Filament\Schemas\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->components([
                                \Filament\Schemas\Components\TextEntry::make('product.name')->label('Produkt'),
                                \Filament\Schemas\Components\TextEntry::make('quantity')->label('Ilość'),
                                \Filament\Schemas\Components\TextEntry::make('price')->label('Cena'),
                            ]),
                    ]),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Pozostawiamy puste dla stabilności buildu
            ]);
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
                // Używamy Tables\Actions, które na pewno istnieją
                \Filament\Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
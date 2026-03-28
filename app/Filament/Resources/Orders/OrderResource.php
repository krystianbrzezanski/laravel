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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Formularz zostawiamy pusty dla stabilności
            ]);
    }

    // NOWA METODA: To pokaże produkty po kliknięciu w zamówienie
    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Szczegóły klienta')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('customer_name')->label('Klient'),
                        \Filament\Infolists\Components\TextEntry::make('email')->label('Email'),
                        \Filament\Infolists\Components\TextEntry::make('status')->badge(),
                        \Filament\Infolists\Components\TextEntry::make('total_price')->money('pln')->label('Suma całkowita'),
                    ])->columns(2),

                \Filament\Infolists\Components\Section::make('Kupione produkty')
                    ->schema([
                        \Filament\Infolists\Components\RepeatableEntry::make('items') // odnosi się do relacji w modelu Order
                            ->label('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('product.name')->label('Produkt'),
                                \Filament\Infolists\Components\TextEntry::make('quantity')->label('Ilość'),
                                \Filament\Infolists\Components\TextEntry::make('price')->money('pln')->label('Cena jedn.'),
                            ])->columns(3)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Klient'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Suma'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->actions([
                // Dodajemy bezpieczny przycisk podglądu (Oko)
                \Filament\Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Puste
            ]);
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
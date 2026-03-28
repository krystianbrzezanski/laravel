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

    /**
     * W Twojej wersji infolist() musi przyjmować i zwracać Schema.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Szczegóły zamówienia')
                    ->columns(2)
                    ->components([
                        \Filament\Schemas\Components\TextEntry::make('customer_name')
                            ->label('Klient'),
                        \Filament\Schemas\Components\TextEntry::make('email')
                            ->label('Email'),
                        \Filament\Schemas\Components\TextEntry::make('status')
                            ->badge(),
                        \Filament\Schemas\Components\TextEntry::make('total_price')
                            ->label('Suma całkowita'),
                    ]),

                \Filament\Schemas\Components\Section::make('Kupione produkty')
                    ->components([
                        \Filament\Schemas\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->components([
                                \Filament\Schemas\Components\TextEntry::make('product.name')
                                    ->label('Produkt'),
                                \Filament\Schemas\Components\TextEntry::make('quantity')
                                    ->label('Ilość'),
                                \Filament\Schemas\Components\TextEntry::make('price')
                                    ->label('Cena jedn.'),
                            ]),
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
                // Pełna ścieżka zapobiega błędowi "Class not found" widocznemu w logach
                \Filament\Tables\Actions\ViewAction::make(),
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
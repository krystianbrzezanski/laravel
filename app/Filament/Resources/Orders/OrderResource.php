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

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Szczegóły zamówienia')
                    ->schema([
                        \Filament\Schemas\Components\TextEntry::make('customer_name')->label('Klient'),
                        \Filament\Schemas\Components\TextEntry::make('email'),
                        \Filament\Schemas\Components\TextEntry::make('status'),
                        \Filament\Schemas\Components\TextEntry::make('total_price')->label('Suma'),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Produkty')
                    ->schema([
                        \Filament\Schemas\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                \Filament\Schemas\Components\TextEntry::make('product.name')->label('Produkt'),
                                \Filament\Schemas\Components\TextEntry::make('quantity')->label('Ilość'),
                                \Filament\Schemas\Components\TextEntry::make('price')->label('Cena'),
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
                // W tej wersji Filamentu akcje muszą być definiowane przez Schemas
                \Filament\Schemas\Actions\Action::make('view')
                    ->label('Zobacz')
                    ->icon('heroicon-m-eye')
                    ->infolist(fn (Schema $schema) => static::infolist($schema)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }
}
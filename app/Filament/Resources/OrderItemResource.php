<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\OrderItem;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderItemResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderItemResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $modelLabel = 'Item Pesanan';

    protected static ?string $pluralModelLabel = 'Item Pesanan';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Toko';

    protected static ?string $navigationLabel = 'Item Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('product_id')
                    ->label('Informasi produk')
                    ->relationship('product')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Nama produk')->disabled(),
                        Forms\Components\TextInput::make('SKU')->label('SKU')->disabled(),
                        Forms\Components\TextInput::make('quantity')->label('Jumlah')->disabled(),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga')
                            ->prefix('Rp ')
                            ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                            ->disabled(),
                    ]),
                Forms\Components\Fieldset::make('order_id')
                    ->relationship('order')
                    ->label('Informasi pesanan')
                    ->schema([
                        Forms\Components\Fieldset::make('user_id')
                            ->label('Informasi pembeli')
                            ->relationship('user')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Nama')->disabled(),
                                Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                            ]),
                    ])
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('product.image')->searchable(),
                Tables\Columns\TextColumn::make('product.SKU')->sortable(),
                Tables\Columns\TextColumn::make('product.name')->sortable(),
                Tables\Columns\TextColumn::make('quantity')->sortable(),
                Tables\Columns\BadgeColumn::make('order.status')
                    ->label('Status pesanan')
                    ->enum([
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                    ])
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'processing',
                        'success' => 'completed',
                        'danger' => 'canceled',
                    ])->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->prefix('Rp ')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                // Hapus atau komentari baris di bawah ini
                // FilamentExportBulkAction::make('export'),
            ])
            ->headerActions([
                // Hapus atau komentari baris di bawah ini
                // FilamentExportHeaderAction::make('export')
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
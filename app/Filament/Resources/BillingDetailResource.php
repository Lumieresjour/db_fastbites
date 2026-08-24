<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\BillingDetail;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BillingDetailResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\BillingDetailResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class BillingDetailResource extends Resource
{
    protected static ?string $model = BillingDetail::class;

    protected static ?string $modelLabel = 'Detail Pembayaran';

    protected static ?string $pluralModelLabel = 'Detail Pembayaran';

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Pelanggan';

    protected static ?string $navigationLabel = 'Detail Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    //diganti
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('ID pengguna')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nama pengguna')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.email')->label('Email pengguna')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('Nomor telepon')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('billing_address')->label('Alamat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->label('Kota')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('country')->label('Provinsi')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export')->label('Ekspor'),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')->label('Ekspor')
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
            'index' => Pages\ListBillingDetails::route('/'),
            'create' => Pages\CreateBillingDetail::route('/create'),
            'edit' => Pages\EditBillingDetail::route('/{record}/edit'),
        ];
    }
}

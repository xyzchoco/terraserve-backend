<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'id';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk'),

                Tables\Columns\TextColumn::make('product.price')
                    ->label('Harga Satuan')
                    ->money('IDR'),
                
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah'),
            ])
            ->actions([])
            ->headerActions([]);
    }
}
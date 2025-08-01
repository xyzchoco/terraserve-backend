<?php

namespace App\Filament\Resources\FarmerApplicationResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ApplicationProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'applicationProducts';

    protected static ?string $title = 'Contoh Produk yang Didaftarkan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form tidak kita perlukan karena data hanya untuk dilihat
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->disk('public'), // Wajib

                TextColumn::make('name')->label('Nama Produk'),
                TextColumn::make('category.name')->label('Kategori'),
                TextColumn::make('price')->label('Harga')->money('IDR'),
                TextColumn::make('stock')->label('Stok'),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoryResource\Pages;
use App\Models\ProductCategory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Manajemen Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255),
                
                // TAMBAHKAN INI UNTUK UPLOAD GAMBAR
                FileUpload::make('icon_url')
                    ->label('Ikon Kategori')
                    ->image() // Menandakan ini adalah input gambar
                    ->disk('public') // Menyimpan ke disk 'public'
                    ->directory('category_icons') // Menyimpan di dalam folder storage/app/public/category_icons
                    ->visibility('public')
                    ->columnSpanFull(), // Membuat field mengambil lebar penuh
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TAMBAHKAN INI UNTUK MENAMPILKAN GAMBAR
                ImageColumn::make('icon_url')
                    ->label('Ikon')
                    ->disk('public') // Mengambil gambar dari disk 'public'
                    ->circular(), // Menampilkan gambar dalam bentuk lingkaran

                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Jumlah Produk')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }    
}

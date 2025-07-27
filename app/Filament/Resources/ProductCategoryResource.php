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
                TextInput::make('name')->label('Nama Kategori')->required(),
                
                FileUpload::make('icon_url')
                    ->label('Ikon Kategori (Untuk Dashboard)')
                    ->image()
                    ->disk('public')
                    ->directory('category_icons')
                    ->required(fn (string $context): bool => $context === 'create'),

                // --- TAMBAHKAN FIELD INI ---
                FileUpload::make('image_url')
                    ->label('Gambar Kategori (Untuk Halaman Kategori)')
                    ->image()
                    ->disk('public')
                    ->directory('category_images') // Simpan di folder terpisah
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }


    
    public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    ImageColumn::make('icon_url')->label('Ikon')->disk('public')->circular(),
                    
                    // --- TAMBAHKAN KOLOM INI ---
                    ImageColumn::make('image_url')->label('Gambar')->disk('public'),

                    TextColumn::make('name')->label('Nama Kategori')->searchable(),
                    TextColumn::make('products_count')->counts('products')->label('Jumlah Produk'),
                ])
                // ... sisa kode
                ;
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

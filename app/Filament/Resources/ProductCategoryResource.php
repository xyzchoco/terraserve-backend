<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProductCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\ProductCategoryResource\Pages;

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
                    ->label('Nama Kategori Induk (Untuk Dashboard)')
                    ->required(),
                FileUpload::make('icon_url')
                    ->label('Ikon Kategori (Untuk Dashboard)')
                    ->image()->disk('public')->directory('category_icons')
                    ->required(fn (string $context): bool => $context === 'create'),
                
                Repeater::make('subCategories')
                    ->label('Subkategori (Untuk Halaman "Semua Kategori")')
                    ->relationship() // Menghubungkan ke relasi 'subCategories' di model
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Subkategori')
                            ->required(),
                        FileUpload::make('image_url')
                            ->label('Gambar Subkategori')
                            ->image()->disk('public')->directory('subcategory_images')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->helperText('Jika tidak ada subkategori, maka kategori induk ini yang akan tampil.'),
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

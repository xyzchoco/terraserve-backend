<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryBannerResource\Pages;
use App\Models\CategoryBanner;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Import komponen yang akan digunakan
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ColorColumn;

class CategoryBannerResource extends Resource
{
    protected static ?string $model = CategoryBanner::class;
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationLabel = 'Banner Kategori';
    protected static ?string $navigationGroup = 'Manajemen Konten';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->columnSpanFull(),
                TextInput::make('description')->required()->columnSpanFull(),
                TextInput::make('button_text')->label('Teks Tombol')->default('Belanja Sekarang')->required(),
                ColorPicker::make('title_text_color')->label('Warna Teks Judul'),

                // --- ✅ PERBAIKAN DI SINI ---
                FileUpload::make('image_url')
                    ->label('Gambar Banner')
                    ->image()
                    ->disk('public')
                    ->directory('category_banner_images')
                    // Hanya wajib diisi saat membuat baru
                    ->required(fn (string $context): bool => $context === 'create')
                    ->columnSpanFull(),

                ColorPicker::make('background_color')->label('Warna Latar Belakang')->required(),
                ColorPicker::make('button_background_color')->label('Warna Tombol'),
                ColorPicker::make('button_text_color')->label('Warna Teks Tombol'),
                Toggle::make('is_active')->label('Aktifkan Banner Ini?'),
            ]);
    }  

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk('public')
                    ->width(120)
                    ->height(80),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                ColorColumn::make('background_color')
                    ->label('BG'),
                ColorColumn::make('title_text_color')
                    ->label('Teks Judul'),
                ColorColumn::make('button_background_color')
                    ->label('Tombol'),
                ColorColumn::make('button_text_color')
                    ->label('Teks Tombol'),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryBanners::route('/'),
            'create' => Pages\CreateCategoryBanner::route('/create'),
            'edit' => Pages\EditCategoryBanner::route('/{record}/edit'),
        ];
    }
}

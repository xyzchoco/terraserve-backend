<?php

namespace App\Filament\Resources;

use App\Models\Banner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DashboardBanner;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\Pages\EditBanner;
use App\Filament\Resources\BannerResource\Pages\ListBanners;
use App\Filament\Resources\BannerResource\Pages\CreateBanner;

class BannerResource extends Resource
{
    protected static ?string $model = DashboardBanner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Banner Dashboard';

    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Judul Banner')->required()->columnSpanFull(),
                TextInput::make('description')->label('Teks Diskon (Deskripsi)')->required(),
                FileUpload::make('image_url')->label('Gambar Model')->image()->disk('public')->directory('banner_images')->required(),
                
                // --- PERUBAHAN DI SINI ---
                ColorPicker::make('gradient_start_color')
                    ->label('Warna Awal (Wajib)')
                    ->helperText('Isi ini untuk warna solid.')
                    ->required(),
                ColorPicker::make('gradient_middle_color')
                    ->label('Warna Tengah (Opsional)')
                    ->helperText('Isi ini untuk gradasi 3 warna.'),
                ColorPicker::make('gradient_end_color')
                    ->label('Warna Akhir (Opsional)')
                    ->helperText('Isi ini dan Warna Awal untuk gradasi 2 warna.'),
                
                Toggle::make('is_active')->label('Aktifkan Banner Ini?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')->label('Gambar')->disk('public')->width(100)->height(80),
                TextColumn::make('title')->searchable(),
                
                // --- PERUBAHAN DI SINI ---
                ColorColumn::make('gradient_start_color')->label('Awal'),
                ColorColumn::make('gradient_middle_color')->label('Tengah'),
                ColorColumn::make('gradient_end_color')->label('Akhir'),

                IconColumn::make('is_active')->label('Status Aktif')->boolean(),
            ])
            // ... sisa kode
            ;
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}

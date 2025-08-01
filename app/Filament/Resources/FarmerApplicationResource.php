<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Models\FarmerApplication;
use Filament\Tables\Actions\Action;
use Filament\Resources\Components\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\FarmerApplicationResource\Pages;
use App\Filament\Resources\FarmerApplicationResource\RelationManagers\ApplicationProductsRelationManager;

class FarmerApplicationResource extends Resource
{
    protected static ?string $model = FarmerApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationLabel = 'Pendaftaran Petani';

    protected static ?string $pluralModelLabel = 'Pendaftaran Petani';
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('Data Pendaftar') // ✅ Gunakan InfolistSection
                    ->columns(2)
                    ->schema([
                        TextEntry::make('full_name')->label('Nama Lengkap Sesuai KTP'), // ✅ Gunakan TextEntry
                        TextEntry::make('nik')->label('NIK'), // ✅ Gunakan TextEntry
                    ]),

                InfolistSection::make('Informasi Lahan & Toko')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('farm_address')->label('Alamat Lahan'),
                        TextEntry::make('land_size_status')->label('Luas & Status Lahan'),
                        TextEntry::make('store_name')->label('Nama Toko'),
                        TextEntry::make('product_type')->label('Jenis Produk'),
                        TextEntry::make('store_description')->label('Deskripsi Toko')->columnSpanFull(),
                        TextEntry::make('store_address')->label('Alamat Toko')->columnSpanFull(),
                    ]),

                InfolistSection::make('Dokumen Terlampir')
                    ->columns(2)
                    ->schema([
                        // ✅ Gunakan ImageEntry untuk menampilkan gambar
                        ImageEntry::make('ktp_photo_path')
                            ->label('Foto KTP')
                            ->disk('public')
                            ->height(200)
                            ->extraAttributes(['class' => 'rounded-lg']), // Contoh: Tambahkan kelas CSS
                        ImageEntry::make('face_photo_path')
                            ->label('Foto Wajah')
                            ->disk('public')
                            ->height(200)
                            ->extraAttributes(['class' => 'rounded-lg']),
                        ImageEntry::make('farm_photo_path')
                            ->label('Foto Lahan')
                            ->disk('public')
                            ->height(200)
                            ->extraAttributes(['class' => 'rounded-lg']),
                        ImageEntry::make('store_logo_path')
                            ->label('Logo Toko')
                            ->disk('public')
                            ->height(200)
                            ->extraAttributes(['class' => 'rounded-lg']),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Pendaftar')->searchable(),
                TextColumn::make('store_name')->label('Nama Toko')->searchable(),
                ImageColumn::make('ktp_photo_path')->label('KTP')->square(),
                ImageColumn::make('store_logo_path')->label('Logo Toko')->square(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('created_at')->label('Tanggal Daftar')->since(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->label('Lihat Detail'),
                    Action::make('approve')
                        ->label('Setujui')
                        ->color('success')->icon('heroicon-o-check-circle')
                        ->visible(fn (FarmerApplication $record) => $record->status === 'pending')
                        ->action(function (FarmerApplication $record) {
                            $user = $record->user;
                            $user->roles = 'PETANI'; 
                            $user->save();
                            $record->update(['status' => 'approved']);
                            Notification::make()->title('Pendaftaran disetujui')->success()->send();
                        })->requiresConfirmation(),

                    Action::make('reject')
                        ->label('Tolak')
                        ->color('danger')->icon('heroicon-o-x-circle')
                        ->visible(fn (FarmerApplication $record) => $record->status === 'pending')
                        ->form([
                            Textarea::make('rejection_reason')->label('Alasan Penolakan')->required(),
                        ])
                        ->action(function (FarmerApplication $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'rejection_reason' => $data['rejection_reason'],
                            ]);
                            Notification::make()->title('Pendaftaran ditolak')->success()->send();
                        }),
                ])
            ]);
    }

    public static function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge(fn () => FarmerApplication::where('status', 'pending')->count())
                ->badgeColor('warning'),
            'approved' => Tab::make('Disetujui')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))
                ->badge(fn () => FarmerApplication::where('status', 'approved')->count())
                ->badgeColor('success'),
            'rejected' => Tab::make('Ditolak')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))
                ->badge(fn () => FarmerApplication::where('status', 'rejected')->count())
                ->badgeColor('danger'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            ApplicationProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFarmerApplications::route('/'),
            'view' => Pages\ViewFarmerApplication::route('/{record}'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRecordUrl(Model $record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }
}

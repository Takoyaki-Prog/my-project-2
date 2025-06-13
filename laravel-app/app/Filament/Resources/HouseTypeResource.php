<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseTypeResource\Pages;
use App\Models\HouseType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HouseTypeResource extends Resource
{
    protected static ?string $model = HouseType::class;

    protected static ?string $label = 'Tipe Rumah';

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'kelola-perumahan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormComponents());
    }

    public static function getFormComponents()
    {
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\Section::make('Informasi tipe rumah')
                        ->description('Masukkan nama tipe rumah, ringkasan singkat, harga jual, dan fasilitas yang tersedia.')
                        ->columnSpan(1)
                        ->collapsible()
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('house_type_name')
                                ->label('Nama tipe rumah')
                                ->required()
                                ->prefixIcon('heroicon-o-tag')
                                ->placeholder('Contoh: Tipe 30/60')
                                ->helperText('Masukkan nama tipe rumah sesuai standar.'),

                            Forms\Components\RichEditor::make('summary')
                                ->label('Ringkasan')
                                ->required()
                                ->placeholder('Contoh: Rumah tipe A dengan 2 kamar tidur dan 1 kamar mandi...')
                                ->helperText('Deskripsi singkat tentang tipe rumah.'),

                            Forms\Components\TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->required()
                                ->prefix('RP')
                                ->placeholder('Contoh: 450000000')
                                ->helperText('Harga dalam satuan rupiah.'),

                            Forms\Components\MultiSelect::make('facility_id')
                                ->label('Fasilitas rumah')
                                ->relationship('facilities', 'facility_name')
                                ->preload()
                                ->searchable()
                                ->createOptionForm(FacilityResource::getFormComponents())
                                ->required()
                                ->prefixIcon('heroicon-o-cog')
                                ->placeholder('Pilih fasilitas yang tersedia')
                                ->helperText('Pilih fasilitas yang tersedia di rumah ini.'),
                        ]),

                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Gambar tipe rumah')
                            ->description('Unggah gambar utama yang mewakili tipe rumah ini.')
                            ->columnSpan(1)
                            ->collapsible()
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('house_type_image')
                                    ->label('Gambar tipe rumah')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('gambar-tipe-rumah')
                                    ->maxSize(2048)
                                    ->required()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Unggah gambar utama tipe rumah. Maks. 2MB, format: JPG, PNG, atau WebP.'),
                            ]),

                        Forms\Components\Section::make('Galeri tipe rumah')
                            ->description('Tambah galeri gambar untuk menampilkan berbagai sudut tipe rumah.')
                            ->columnSpan(1)
                            ->collapsible()
                            ->icon('heroicon-o-rectangle-stack')
                            ->schema([
                                Forms\Components\Repeater::make('houseTypeGalleries')
                                    ->label('Galeri tipe rumah')
                                    ->relationship('houseTypeGalleries')
                                    ->schema([
                                        Forms\Components\FileUpload::make('house_type_gallery_image')
                                            ->label('Gambar galeri tipe rumah')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('galeri-tipe-rumah')
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->helperText('Unggah gambar tambahan tipe rumah (opsional). Maks. 2MB, format: JPG, PNG, atau WebP.'),

                                        Forms\Components\TextInput::make('house_type_gallery_name')
                                            ->label('Nama galeri tipe rumah')
                                            ->required(fn ($get) => ! empty($get('house_type_gallery_image')))
                                            ->prefixIcon('heroicon-o-tag')
                                            ->placeholder('Contoh: Tampak depan')
                                            ->helperText('Nama deskriptif untuk gambar galeri.'),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi galeri tipe rumah')
                                            ->required(fn ($get) => ! empty($get('house_type_gallery_image')))
                                            ->placeholder('Contoh: Menampilkan sisi depan rumah dengan taman.')
                                            ->helperText('Deskripsi singkat terkait gambar galeri.'),
                                    ]),
                            ]),
                    ]),
                ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableComponents())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getTableComponents()
    {
        return [
            Tables\Columns\ImageColumn::make('house_type_image')
                ->label('Gambar Tipe Rumah')
                ->circular()
                ->toggleable(),

            Tables\Columns\TextColumn::make('house_type_name')
                ->label('Nama Tipe Rumah')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('summary')
                ->label('Ringkasan')
                ->html()
                ->toggleable(),

            Tables\Columns\TextColumn::make('price')
                ->label('Harga')
                ->money('IDR', true)
                ->sortable(),

            Tables\Columns\BadgeColumn::make('facilities.facility_name')
                ->label('Fasilitas Rumah')
                ->wrap()
                ->toggleable(),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(self::getInfolistComponents());
    }

    public static function getInfolistComponents()
    {
        return [
            Infolists\Components\Grid::make(2)
                ->schema([
                    Infolists\Components\Section::make('Informasi tipe rumah')
                        ->description('Data tipe rumah, ringkasan, harga, dan fasilitas.')
                        ->icon('heroicon-o-information-circle')
                        ->collapsible()
                        ->schema([
                            Infolists\Components\TextEntry::make('house_type_name')
                                ->label('Nama tipe rumah')
                                ->icon('heroicon-o-tag')
                                ->helperText('Nama dari tipe rumah ini.'),

                            Infolists\Components\TextEntry::make('summary')
                                ->label('Ringkasan')
                                ->html()
                                ->helperText('Deskripsi singkat tipe rumah.'),

                            Infolists\Components\TextEntry::make('price')
                                ->label('Harga')
                                ->money('IDR', true)
                                ->helperText('Harga dalam rupiah.'),

                            Infolists\Components\TextEntry::make('facilities.facility_name')
                                ->label('Fasilitas rumah')
                                ->icon('heroicon-o-cog')
                                ->helperText('Daftar fasilitas yang tersedia.')
                                ->badge(),
                        ]),

                    Infolists\Components\Section::make('Gambar tipe rumah')
                        ->description('Gambar utama dari tipe rumah.')
                        ->icon('heroicon-o-photo')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Infolists\Components\ImageEntry::make('house_type_image')
                                ->label('Gambar tipe rumah')
                                ->helperText('Gambar utama tipe rumah.')
                                ->circular(),
                        ]),

                    Infolists\Components\Section::make('Galeri tipe rumah')
                        ->description('Kumpulan gambar tambahan dari tipe rumah.')
                        ->icon('heroicon-o-rectangle-stack')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Infolists\Components\RepeatableEntry::make('houseTypeGalleries')
                                ->label('Galeri tipe rumah')
                                ->schema([
                                    Infolists\Components\ImageEntry::make('house_type_gallery_image')
                                        ->label('Gambar galeri tipe rumah')
                                        ->helperText('Gambar tambahan dari tipe rumah.'),

                                    Infolists\Components\TextEntry::make('house_type_gallery_name')
                                        ->label('Nama galeri tipe rumah')
                                        ->icon('heroicon-o-tag')
                                        ->helperText('Nama dari gambar galeri.'),

                                    Infolists\Components\TextEntry::make('description')
                                        ->label('Deskripsi galeri tipe rumah')
                                        ->icon('heroicon-o-document-text')
                                        ->helperText('Penjelasan terkait gambar galeri.'),
                                ]),
                        ]),
                ]),
        ];
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
            'index' => Pages\ListHouseTypes::route('/'),
            'create' => Pages\CreateHouseType::route('/create'),
            'edit' => Pages\EditHouseType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

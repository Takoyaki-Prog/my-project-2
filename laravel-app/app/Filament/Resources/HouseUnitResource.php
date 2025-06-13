<?php

namespace App\Filament\Resources;

use App\Enums\HouseUnitStatusEnum;
use App\Filament\Resources\HouseUnitResource\Pages;
use App\Models\HouseUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HouseUnitResource extends Resource
{
    protected static ?string $model = HouseUnit::class;

    protected static ?string $label = 'Unit Rumah';

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

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
                    Forms\Components\Section::make('Informasi unit rumah')
                        ->description('Masukkan data unit rumah, seperti nama, status, blok, tipe, dan marketing.')
                        ->columnSpan(1)
                        ->collapsible()
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('house_unit_name')
                                ->label('Nama unit rumah')
                                ->required()
                                ->prefixIcon('heroicon-o-tag')
                                ->placeholder('Contoh: A1 / B2')
                                ->helperText('Nama atau kode unit rumah.'),

                            Forms\Components\Select::make('status')
                                ->label('Status unit rumah')
                                ->options(HouseUnitStatusEnum::getOptions())
                                ->required()
                                ->prefixIcon('heroicon-o-adjustments-horizontal')
                                ->placeholder('Pilih status unit')
                                ->helperText('Status ketersediaan unit rumah.'),

                            Forms\Components\Select::make('block_house_unit_id')
                                ->label('Blok unit rumah')
                                ->relationship('blockHouseUnit', 'block_name')
                                ->preload()
                                ->searchable()
                                ->createOptionForm(BlockHouseunitResource::getFormComponents())
                                ->required()
                                ->prefixIcon('heroicon-o-map')
                                ->placeholder('Pilih blok')
                                ->helperText('Blok atau cluster tempat unit rumah berada.'),

                            Forms\Components\Select::make('house_type_id')
                                ->label('Tipe rumah')
                                ->relationship('houseType', 'house_type_name')
                                ->preload()
                                ->searchable()
                                ->createOptionForm(HouseTypeResource::getFormComponents())
                                ->required()
                                ->prefixIcon('heroicon-o-home-modern')
                                ->placeholder('Pilih tipe rumah')
                                ->helperText('Tipe rumah yang digunakan unit ini.'),

                            Forms\Components\Select::make('marketing_id')
                                ->label('Marketing')
                                ->relationship('marketing', 'name')
                                ->preload()
                                ->searchable()
                                ->createOptionForm(MarketingResource::getFormComponents())
                                ->required()
                                ->prefixIcon('heroicon-o-user')
                                ->placeholder('Pilih marketing')
                                ->helperText('Marketing yang bertanggung jawab atas unit ini.'),
                        ]),

                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Gambar unit rumah')
                            ->description('Unggah gambar utama dari unit rumah.')
                            ->columnSpan(1)
                            ->collapsible()
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('house_unit_image')
                                    ->label('Gambar unit rumah')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('gambar-unit-rumah')
                                    ->maxSize(2048)
                                    ->required()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Unggah gambar utama unit rumah. Maks. 2MB, format: JPG, PNG, atau WebP.'),
                            ]),

                        Forms\Components\Section::make('Galeri unit rumah')
                            ->description('Tambah galeri gambar untuk menampilkan berbagai sudut unit rumah.')
                            ->columnSpan(1)
                            ->collapsible()
                            ->icon('heroicon-o-rectangle-stack')
                            ->schema([
                                Forms\Components\Repeater::make('houseUnitGalleries')
                                    ->label('Galeri unit rumah')
                                    ->relationship('houseUnitGalleries')
                                    ->defaultItems(1)
                                    ->schema([
                                        Forms\Components\FileUpload::make('house_unit_gallery_image')
                                            ->label('Gambar galeri unit rumah')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('galeri-unit-rumah')
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->helperText('Unggah gambar tambahan unit rumah. Maks. 2MB, format: JPG, PNG, atau WebP.'),

                                        Forms\Components\TextInput::make('house_unit_gallery_name')
                                            ->label('Nama galeri unit rumah')
                                            ->required(fn ($get) => ! empty($get('house_unit_gallery_image')))
                                            ->prefixIcon('heroicon-o-tag')
                                            ->placeholder('Contoh: Tampak depan')
                                            ->helperText('Nama deskriptif untuk gambar galeri.'),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi galeri unit rumah')
                                            ->required(fn ($get) => ! empty($get('house_unit_gallery_image')))
                                            ->placeholder('Contoh: Tampak depan dengan taman kecil...')
                                            ->helperText('Deskripsi singkat terkait gambar.'),
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
                Tables\Filters\MultiSelectFilter::make('status')
                    ->label('Berdasarkan status')
                    ->options(HouseUnitStatusEnum::getOptions()),

                Tables\Filters\MultiSelectFilter::make('blockHouseUnit')
                    ->label('Berdasarkan blok unit rumah')
                    ->relationship('blockHouseUnit', 'block_name')
                    ->preload()
                    ->searchable(),

                Tables\Filters\MultiSelectFilter::make('houseType')
                    ->label('Berdasarkan tipe rumah')
                    ->relationship('houseType', 'house_type_name')
                    ->preload()
                    ->searchable(),

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
            Tables\Columns\ImageColumn::make('house_unit_image')
                ->label('Gambar Unit Rumah')
                ->circular()
                ->toggleable(),

            Tables\Columns\TextColumn::make('house_unit_name')
                ->label('Nama Unit Rumah')
                ->searchable()
                ->sortable(),

            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('blockHouseUnit.block_name')
                ->label('Blok Unit Rumah')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('houseType.house_type_name')
                ->label('Tipe Rumah')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('marketing.name')
                ->label('Marketing')
                ->searchable()
                ->sortable()
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
                    Infolists\Components\Section::make('Informasi unit rumah')
                        ->description('Detail nama unit, status, blok, tipe, dan marketing.')
                        ->icon('heroicon-o-information-circle')
                        ->collapsible()
                        ->schema([
                            Infolists\Components\TextEntry::make('house_unit_name')
                                ->label('Nama unit rumah')
                                ->icon('heroicon-o-tag')
                                ->helperText('Nama dari unit rumah ini.'),

                            Infolists\Components\TextEntry::make('status')
                                ->label('Status unit rumah')
                                ->icon('heroicon-o-adjustments-horizontal')
                                ->helperText('Status terkini dari unit.'),

                            Infolists\Components\TextEntry::make('blockHouseUnit.block_name')
                                ->label('Blok unit rumah')
                                ->icon('heroicon-o-map')
                                ->helperText('Blok tempat unit berada.'),

                            Infolists\Components\TextEntry::make('houseType.house_type_name')
                                ->label('Tipe rumah')
                                ->icon('heroicon-o-home-modern')
                                ->helperText('Tipe rumah dari unit ini.'),

                            Infolists\Components\TextEntry::make('marketing.name')
                                ->label('Marketing')
                                ->icon('heroicon-o-user')
                                ->helperText('Marketing yang menangani unit ini.'),
                        ]),

                    Infolists\Components\Section::make('Gambar unit rumah')
                        ->description('Gambar utama dari unit rumah.')
                        ->icon('heroicon-o-photo')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Infolists\Components\ImageEntry::make('house_unit_image')
                                ->label('Gambar unit rumah')
                                ->helperText('Gambar utama dari unit rumah ini.')
                                ->circular(),
                        ]),

                    Infolists\Components\Section::make('Galeri unit rumah')
                        ->description('Kumpulan gambar tambahan dari unit rumah.')
                        ->icon('heroicon-o-rectangle-stack')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Infolists\Components\RepeatableEntry::make('houseUnitGalleries')
                                ->label('Galeri unit rumah')
                                ->schema([
                                    Infolists\Components\ImageEntry::make('house_unit_gallery_image')
                                        ->label('Gambar galeri unit rumah')
                                        ->helperText('Gambar tambahan dari unit rumah.'),

                                    Infolists\Components\TextEntry::make('house_unit_gallery_name')
                                        ->label('Nama galeri unit rumah')
                                        ->icon('heroicon-o-tag')
                                        ->helperText('Nama untuk gambar ini.'),

                                    Infolists\Components\TextEntry::make('description')
                                        ->label('Deskripsi galeri unit rumah')
                                        ->icon('heroicon-o-document-text')
                                        ->helperText('Deskripsi singkat gambar galeri.'),
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
            'index' => Pages\ListHouseUnits::route('/'),
            'create' => Pages\CreateHouseUnit::route('/create'),
            'edit' => Pages\EditHouseUnit::route('/{record}/edit'),
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

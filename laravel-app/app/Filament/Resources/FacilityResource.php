<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityResource\Pages;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $label = 'Fasilitas Unit Rumah';

    protected static ?string $navigationIcon = 'heroicon-o-cog';

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
                    Forms\Components\Section::make('Informasi fasilitas unit rumah')
                        ->description('Isi detail nama dan deskripsi fasilitas.')
                        ->icon('heroicon-o-information-circle')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Forms\Components\TextInput::make('facility_name')
                                ->label('Nama fasilitas')
                                ->placeholder('Contoh: Kolam Renang')
                                ->helperText('Masukkan nama fasilitas yang tersedia.')
                                ->required()
                                ->prefixIcon('heroicon-o-tag'),

                            Forms\Components\RichEditor::make('description')
                                ->label('Deskripsi')
                                ->placeholder('Tulis deskripsi fasilitas di sini...')
                                ->helperText('Tuliskan informasi tambahan mengenai fasilitas.')
                                ->required(),
                        ]),
                    Forms\Components\Section::make('Gambar fasilitas')
                        ->description('Unggah gambar fasilitas, format .jpg atau .png disarankan.')
                        ->icon('heroicon-o-photo')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Forms\Components\FileUpload::make('facility_image')
                                ->label('Gambar fasilitas')
                                ->image()
                                ->imageEditor()
                                ->directory('gambar-fasilitas-unit-rumah')
                                ->maxSize(2048)
                                ->required()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->helperText('Unggah gambar fasilitas. Maks. 2MB, format: JPG, PNG, atau WebP.'),
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
            Tables\Columns\ImageColumn::make('facility_image')
                ->label('Gambar')
                ->circular()
                ->toggleable(),

            Tables\Columns\TextColumn::make('facility_name')
                ->label('Nama Fasilitas')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi')
                ->limit(50)
                ->tooltip(fn ($state) => strip_tags($state))
                ->wrap()
                ->html()
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
                    Infolists\Components\Section::make('Informasi fasilitas unit rumah')
                        ->description('Detail nama dan deskripsi fasilitas yang tersedia.')
                        ->icon('heroicon-o-information-circle')
                        ->collapsible()
                        ->schema([
                            Infolists\Components\TextEntry::make('facility_name')
                                ->label('Nama fasilitas')
                                ->icon('heroicon-o-tag')
                                ->helperText('Nama fasilitas yang tersedia.'),

                            Infolists\Components\TextEntry::make('description')
                                ->label('Deskripsi')
                                ->html()
                                ->columnSpan('full')
                                ->helperText('Penjelasan lengkap mengenai fasilitas.'),
                        ]),

                    Infolists\Components\Section::make('Gambar fasilitas')
                        ->description('Gambar utama fasilitas perumahan.')
                        ->icon('heroicon-o-photo')
                        ->collapsible()
                        ->schema([
                            Infolists\Components\ImageEntry::make('facility_image')
                                ->label('Gambar fasilitas')
                                ->circular()
                                ->helperText('Gambar visual dari fasilitas perumahan.'),
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
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
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

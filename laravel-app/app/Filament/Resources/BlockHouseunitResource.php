<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockHouseunitResource\Pages;
use App\Models\BlockHouseunit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlockHouseunitResource extends Resource
{
    protected static ?string $model = BlockHouseunit::class;

    protected static ?string $label = 'Blok Unit Rumah';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'kelola-perumahan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormComponents());
    }

    public static function getFormComponents()
    {
        return [
            Forms\Components\Section::make('Informasi blok unit rumah')
                ->description('Masukkan data nama blok dan koordinat lokasi.')
                ->icon('heroicon-o-information-circle')
                ->collapsible()
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('block_name')
                                ->label('Nama blok')
                                ->placeholder('Masukkan nama blok')
                                ->helperText('Contoh: Blok A, Blok B, Blok C')
                                ->prefixIcon('heroicon-o-map')
                                ->required()
                                ->columnSpan('full'),

                            Forms\Components\TextInput::make('latitude')
                                ->label('Latitude')
                                ->placeholder('-6.200000')
                                ->helperText('Garis lintang lokasi dalam format desimal. Contoh: -6.200000')
                                ->prefixIcon('heroicon-o-map-pin')
                                ->numeric()
                                ->required(),

                            Forms\Components\TextInput::make('longitude')
                                ->label('Longitude')
                                ->placeholder('106.816666')
                                ->helperText('Garis bujur lokasi dalam format desimal. Contoh: 106.816666')
                                ->prefixIcon('heroicon-o-map-pin')
                                ->numeric()
                                ->required(),
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
            Tables\Columns\TextColumn::make('block_name')
                ->label('Nama Blok')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('latitude')
                ->label('Latitude')
                ->sortable()
                ->copyable()
                ->copyMessage('Latitude disalin')
                ->tooltip('Klik untuk menyalin latitude')
                ->toggleable(),

            Tables\Columns\TextColumn::make('longitude')
                ->label('Longitude')
                ->sortable()
                ->copyable()
                ->copyMessage('Longitude disalin')
                ->tooltip('Klik untuk menyalin longitude')
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
            Infolists\Components\Section::make('Informasi blok unit rumah')
                ->description('Detail nama blok dan koordinat lokasi.')
                ->icon('heroicon-o-information-circle')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Infolists\Components\TextEntry::make('block_name')
                        ->label('Nama blok')
                        ->icon('heroicon-o-map')
                        ->helperText('Nama blok perumahan yang terdaftar.'),

                    Infolists\Components\TextEntry::make('latitude')
                        ->label('Latitude')
                        ->copyable()
                        ->copyMessage('Latitude disalin')
                        ->tooltip('Klik untuk menyalin latitude')
                        ->icon('heroicon-o-globe-alt')
                        ->helperText('Koordinat lintang lokasi blok.'),

                    Infolists\Components\TextEntry::make('longitude')
                        ->label('Longitude')
                        ->copyable()
                        ->copyMessage('Longitude disalin')
                        ->tooltip('Klik untuk menyalin longitude')
                        ->icon('heroicon-o-globe-alt')
                        ->helperText('Koordinat bujur lokasi blok.'),
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
            'index' => Pages\ListBlockHouseunits::route('/'),
            'create' => Pages\CreateBlockHouseunit::route('/create'),
            'edit' => Pages\EditBlockHouseunit::route('/{record}/edit'),
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

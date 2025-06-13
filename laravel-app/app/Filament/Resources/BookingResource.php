<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'kelola-booking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableComponents())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewACtion::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTableComponents() {
        return [
            Tables\Columns\TextColumn::make('customer.name')
                ->label('Detail Customer')
                ->description(fn($record) => $record->customer->email)
                ->searchable()
                ->sortable(),
            
            Tables\Columns\TextColumn::make('houseUnit.house_unit_name')
                ->label('Detail Unit')
                ->description(fn ($record) => 
                    "{$record->houseUnit->blockHouseUnit->block_name}, {$record->houseUnit->houseType->house_type_name}"
                )
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('payment_deadline')
                ->label('Batas Pembayaran')
                ->formatStateUsing(function ($state) {
                    $datetime = Carbon::parse($state);
                    return $datetime->translatedFormat('l, d F Y H:i');
                })
                ->toggleable(),

            Tables\Columns\TextColumn::make('cost')
                ->label('Biaya Booking')
                ->money('IDR')
                ->numeric()
                ->toggleable(),

            Tables\Columns\BadgeColumn::make('status')
                ->label('Status Booking')
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
            Infolists\Components\Section::make('Detail customer')
                ->description('')
                ->schema([
                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\TextEntry::make('customer.name')
                                ->label('Nama'),

                            Infolists\Components\TextEntry::make('customer.email')
                                ->label('Alamat email'),
                        ]),
                ]),

            Infolists\Components\Section::make('Detail booking')
                ->description('')
                ->schema([
                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\Textentry::make('houseUnit.house_unit_name')
                                ->label('Unit'),

                            Infolists\Components\Textentry::make('houseUnit.blockHouseUnit.block_name')
                                ->label('Blok'),

                            Infolists\Components\TextEntry::make('houseUnit.houseType.house_type_name')
                                ->label('Tipe'),

                            Infolists\Components\Textentry::make('')
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
            'index' => Pages\ListBookings::route('/'),
            // 'create' => Pages\CreateBooking::route('/create'),
            // 'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

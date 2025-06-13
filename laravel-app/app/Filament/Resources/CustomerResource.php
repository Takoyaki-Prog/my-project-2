<?php

namespace App\Filament\Resources;

use App\Enums\UserRoleEnum;
use App\Filament\Resources\CustomerResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Pelanggan';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'kelola-pengguna';

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
                    Forms\Components\Section::make('Data indentitas pelanggan')
                        ->description('Masukkan nama lengkap dan nomor telepon sesuai dokumen resmi.')
                        ->icon('heroicon-o-identification')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama')
                                ->placeholder('Masukkan nama lengkap')
                                ->helperText('Gunakan nama asli sesuai identitas.')
                                ->required()
                                ->prefixIcon('heroicon-o-user'),

                            Forms\Components\TextInput::make('phone')
                                ->label('Nomor telepon')
                                ->placeholder('Masukkan nomor telepon')
                                ->helperText('Contoh: +6281234567890')
                                ->tel()
                                ->required()
                                ->prefixIcon('heroicon-o-phone'),

                            Forms\Components\FileUpload::make('photo')
                                ->label('Foto profil')
                                ->image()
                                ->imageEditor()
                                ->directory('foto-marketing')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->nullable()
                                ->helperText('Unggah foto wajah yang jelas (opsional). Maks. 2MB, format: JPG, PNG, atau WebP.'),
                        ]),

                    Forms\Components\Section::make('Data akun pelanggan')
                        ->description('Informasi akun untuk login ke sistem.')
                        ->icon('heroicon-o-shield-exclamation')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Forms\Components\TextInput::make('email')
                                ->label('Alamat email')
                                ->email()
                                ->unique(ignoreRecord: true)
                                ->placeholder('contoh@email.com')
                                ->helperText('Pastikan email aktif dan benar.')
                                ->required()
                                ->prefixIcon('heroicon-o-envelope'),

                            Forms\Components\TextInput::make('password')
                                ->label('Kata sandi')
                                ->password()
                                ->placeholder('Minimal 8 karakter')
                                ->minLength(8)
                                ->helperText('Gunakan kombinasi huruf dan angka.')
                                ->revealable(filament()->arePasswordsRevealable())
                                ->required()
                                ->visibleOn('create')
                                ->prefixIcon('heroicon-o-lock-closed'),

                            Forms\Components\TextInput::make('passwordConfirmation')
                                ->label('Konfirmasi kata sandi')
                                ->password()
                                ->placeholder('Ulangi kata sandi')
                                ->same('password')
                                ->helperText('Pastikan sama persis dengan kata sandi.')
                                ->revealable(filament()->arePasswordsRevealable())
                                ->required()
                                ->visibleOn('create')
                                ->dehydrated(false)
                                ->prefixIcon('heroicon-o-lock-closed')
                                ->columnSpanFull(),
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
            Tables\Columns\ImageColumn::make('photo')
                ->label('Foto Profil')
                ->circular()
                ->toggleable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('phone')
                ->label('Nomor Telepon')
                ->searchable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('email')
                ->label('Alamat Email')
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
                    Infolists\Components\Section::make('Data indentitas pelanggan')
                        ->description('Informasi dasar marketing.')
                        ->icon('heroicon-o-identification')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Infolists\Components\ImageEntry::make('photo')
                                ->label('Foto profil')
                                ->circular()
                                ->helperText('Foto marketing.'),

                            Infolists\Components\TextEntry::make('name')
                                ->label('Nama')
                                ->icon('heroicon-o-user')
                                ->helperText('Nama lengkap marketing.'),

                            Infolists\Components\TextEntry::make('phone')
                                ->label('Nomor telepon')
                                ->icon('heroicon-o-phone')
                                ->helperText('Nomor telepon aktif marketing.'),
                        ]),

                    Infolists\Components\Section::make('Data akun pelanggan')
                        ->description('Email yang digunakan untuk login.')
                        ->icon('heroicon-o-shield-exclamation')
                        ->collapsible()
                        ->columnSpan(1)
                        ->schema([
                            Infolists\Components\TextEntry::make('email')
                                ->label('Alamat email')
                                ->icon('heroicon-o-envelope')
                                ->helperText('Alamat email yang terdaftar.'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', UserRoleEnum::CUSTOMER)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

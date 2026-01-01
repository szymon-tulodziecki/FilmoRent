<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WiadomoscKontaktowaResource\Pages;
use App\Models\WiadomoscKontaktowa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WiadomoscKontaktowaResource extends Resource
{
    protected static ?string $model = WiadomoscKontaktowa::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static ?string $navigationLabel = 'Wiadomości';
    
    protected static ?string $pluralLabel = 'Wiadomości kontaktowe';
    
    protected static ?string $navigationGroup = 'Komunikacja';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $slug = 'wiadomosci';

    public static function getCreateLabel(): string
    {
        return 'Nowa Wiadomość';
    }

    public static function getEditLabel(): string
    {
        return 'Edytuj Wiadomość';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dane kontaktowe')
                    ->schema([
                        Forms\Components\TextInput::make('imie_nazwisko')
                            ->label('Imię i nazwisko')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('temat')
                            ->label('Temat')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Wiadomość')
                    ->schema([
                        Forms\Components\Textarea::make('wiadomosc')
                            ->label('Treść wiadomości')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'nowa' => 'Nowa',
                                'przeczytana' => 'Przeczytana',
                                'odpowiedziana' => 'Odpowiedziana',
                            ])
                            ->default('nowa')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('imie_nazwisko')
                    ->label('Nadawca')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('temat')
                    ->label('Temat')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 'nowa',
                        'warning' => 'przeczytana',
                        'success' => 'odpowiedziana',
                    ])
                    ->icons([
                        'heroicon-o-envelope' => 'nowa',
                        'heroicon-o-eye' => 'przeczytana',
                        'heroicon-o-check-circle' => 'odpowiedziana',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'nowa' => 'Nowa',
                        'przeczytana' => 'Przeczytana',
                        'odpowiedziana' => 'Odpowiedziana',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('oznacz_przeczytana')
                    ->label('Oznacz jako przeczytaną')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->visible(fn (WiadomoscKontaktowa $record) => $record->status === 'nowa')
                    ->action(fn (WiadomoscKontaktowa $record) => $record->update(['status' => 'przeczytana'])),
                Tables\Actions\Action::make('oznacz_odpowiedziana')
                    ->label('Oznacz jako odpowiedzianą')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (WiadomoscKontaktowa $record) => $record->status !== 'odpowiedziana')
                    ->action(fn (WiadomoscKontaktowa $record) => $record->update(['status' => 'odpowiedziana'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('oznacz_przeczytane')
                        ->label('Oznacz jako przeczytane')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['status' => 'przeczytana'])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWiadomosciKontaktowe::route('/'),
            'view' => Pages\ViewWiadomoscKontaktowa::route('/{record}'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'nowa')->count() ?: null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}

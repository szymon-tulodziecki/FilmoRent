<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProducentResource\Pages;
use App\Filament\Resources\ProducentResource\RelationManagers;
use App\Models\Producent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProducentResource extends Resource
{
    protected static ?string $model = Producent::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    
    protected static ?string $navigationLabel = 'Producenci';
    
    protected static ?string $modelLabel = 'Producent';
    
    protected static ?string $pluralModelLabel = 'Producenci';
    
    protected static ?string $navigationGroup = 'Magazyn';
    
    protected static ?string $slug = 'producenci';

    public static function getNavigationLabel(): string
    {
        return 'Producenci';
    }

    public static function getModelLabel(): string
    {
        return 'Producent';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Producenci';
    }

    public static function getCreateLabel(): string
    {
        return 'Dodaj Producenta';
    }

    public static function getEditLabel(): string
    {
        return 'Edytuj Producenta';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nazwa')
                    ->label('Nazwa producenta')
                    ->required(),
                Forms\Components\Textarea::make('opis')
                    ->label('Opis')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nazwa')
                    ->label('Nazwa')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edytuj'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Usuń zaznaczone'),
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
            'index' => Pages\ListProducents::route('/'),
            'create' => Pages\CreateProducent::route('/create'),
            'edit' => Pages\EditProducent::route('/{record}/edit'),
        ];
    }
}

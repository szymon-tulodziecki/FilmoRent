<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriaResource\Pages;
use App\Filament\Resources\KategoriaResource\RelationManagers;
use App\Models\Kategoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriaResource extends Resource
{
    protected static ?string $model = Kategoria::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Kategorie';
    
    protected static ?string $modelLabel = 'Kategoria';
    
    protected static ?string $pluralModelLabel = 'Kategorie';
    
    protected static ?string $navigationGroup = 'Magazyn';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nazwa')
                    ->label('Nazwa kategorii')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required(),
                Forms\Components\Select::make('rodzic_id')
                    ->relationship('rodzic', 'nazwa')
                    ->label('Kategoria nadrzędna')
                    ->searchable()
                    ->preload(),
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
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rodzic.nazwa')
                    ->label('Kategoria nadrzędna')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListKategorias::route('/'),
            'create' => Pages\CreateKategoria::route('/create'),
            'edit' => Pages\EditKategoria::route('/{record}/edit'),
        ];
    }
}

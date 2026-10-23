<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StationResource\Pages;
use App\Filament\Resources\StationResource\RelationManagers;
use App\Models\Station;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true) // Отслеживаем изменения, когда пользователь уводит фокус с поля
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))), // Автоматически генерируем URL-slug на лету

            TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true), // Проверяем уникальность, игнорируя текущую запись при редактировании

            // Меняем обычное текстовое поле на компонент загрузки файлов
            FileUpload::make('logo')
                ->image() // Разрешаем только картинки
                ->directory('station-logos') // Папка внутри storage/app/public
                ->disk('public') // Явно указываем публичный диск
                ->nullable(),

            Toggle::make('is_active')
                ->required()
                ->default(true),

            Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        StationResource\RelationManagers\ChannelsRelationManager::class,
    ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStations::route('/'),
            'create' => Pages\CreateStation::route('/create'),
            'edit' => Pages\EditStation::route('/{record}/edit'),
        ];
    }
}

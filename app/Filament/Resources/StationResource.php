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

use Filament\Forms\Get; // Важно для отслеживания состояния полей

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            // 1. ТУМБЛЕР: Выбор режима (Ссылка или Файл)
            Forms\Components\Toggle::make('is_external_logo')
                ->label('Использовать внешнюю ссылку для логотипа')
                ->live()
                ->afterStateHydrated(function (Forms\Components\Toggle $component, $state, $record) {
                    if ($record && str_starts_with($record->logo ?? '', 'http')) {
                        $component->state(true);
                    } else {
                        $component->state(false);
                    }
                })
                ->dehydrated(false),

            // 2. ССЫЛКА: Показывается, если тумблер ВКЛЮЧЕН
            Forms\Components\TextInput::make('logo_url')
                ->label('Ссылка на логотип')
                ->url()
                ->maxLength(255)
                ->visible(fn (Forms\Get $get) => $get('is_external_logo') === true)
                ->statePath('logo') // Пишем напрямую в колонку logo
                ->required(fn (Forms\Get $get) => $get('is_external_logo') === true),

            // 3. ФАЙЛ: Показывается, если тумблер ВЫКЛЮЧЕН
            Forms\Components\FileUpload::make('logo_file')
                ->label('Загрузить файл логотипа')
                ->image()
                ->directory('station-logos')
                ->disk('public')
                ->visible(fn (Forms\Get $get) => $get('is_external_logo') === false)
                ->statePath('logo') // Пишем напрямую в колонку logo
                ->required(fn (Forms\Get $get) => $get('is_external_logo') === false),

            Forms\Components\Toggle::make('is_active')
                ->required()
                ->default(true),

            Forms\Components\Textarea::make('description')
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

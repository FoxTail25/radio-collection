<?php

namespace App\Filament\Resources\StationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChannelsRelationManager extends RelationManager
{
    protected static string $relationship = 'channels';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Название канала (например: Основной, Альтернативный, Rock)
                Forms\Components\TextInput::make('name')
                    ->label('Название канала')
                    ->required()
                    ->maxLength(255),

                // Ссылка на аудиопоток из твоей миграции (stream_url)
                Forms\Components\TextInput::make('stream_url')
                    ->label('Адрес аудиопотока')
                    ->url() // Проверяет корректность ввода URL-адреса
                    ->required()
                    ->maxLength(255),

                // Переключатель для главного канала (is_main)
                Forms\Components\Toggle::make('is_main')
                    ->label('Главный канал')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                // Выводим адрес потока в таблицу с возможностью скопировать кликом
                Tables\Columns\TextColumn::make('stream_url')
                    ->label('Адрес потока')
                    ->copyable()
                    ->searchable(),

                // Иконка-индикатор главного канала
                Tables\Columns\IconColumn::make('is_main')
                    ->label('Главный')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                // Здесь при необходимости можно добавить фильтры
            ])
            ->headerActions([
                // Оставляем только создание нового канала
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Заменяем открепление (Detach) на полноценное удаление (Delete)
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

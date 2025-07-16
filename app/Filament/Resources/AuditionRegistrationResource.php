<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditionRegistrationResource\Pages;
use App\Filament\Resources\AuditionRegistrationResource\RelationManagers;
use App\Models\AuditionRegistration;
use App\Models\AuditionSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuditionRegistrationResource extends Resource
{
    protected static ?int $navigationSort = 1;
    protected static ?string $model = AuditionRegistration::class;
    protected static ?string $label = 'Registrations';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('audition_id')
                    ->relationship('audition', 'name')
                    ->required(),
                Forms\Components\Select::make('audition_slot_id')
                    ->options(fn($record) => $record->slots),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('parent_name')
                    ->maxLength(191),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('instrument')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('agreed_terms')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('payment_status')
                    ->required()
                    ->maxLength(191)
                    ->default('pending'),
                Forms\Components\TextInput::make('payment_order_id')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('audition.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('audition_slot_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instrument')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agreed_terms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_order_id')
                    ->searchable(),
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
            'index' => Pages\ListAuditionRegistrations::route('/'),
            'create' => Pages\CreateAuditionRegistration::route('/create'),
            'edit' => Pages\EditAuditionRegistration::route('/{record}/edit'),
        ];
    }
}

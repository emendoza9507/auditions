<?php

namespace App\Filament\Resources\AuditionResource\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\View\Components\Modal;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191)
                    ->columnSpanFull(),
                Forms\Components\Select::make('audition_slot_id')
                    ->label('Time')
                    ->relationship('audition.slots')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->time->format('h:i A'))
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->default(19)
                    ->reactive()
                    ->maxLength(191)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('parent_name')
                    ->visible(fn (Get $get) => $get('age') < 18)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('instrument')
                    ->required()
                    ->maxLength(191)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(191)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('payment_order_id')
                    ->maxLength(191),
                Forms\Components\Checkbox::make('agreed_terms'),
                Forms\Components\Hidden::make('payment_status')
                    ->default('pending'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('age'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New register')->modalWidth('sm'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

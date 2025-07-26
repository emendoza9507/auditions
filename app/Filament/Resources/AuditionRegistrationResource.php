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
                    ->required()
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->reactive(),
                Forms\Components\Select::make('audition_slot_id')
                    ->label('Audition Slot')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->options(function (callable $get) {
                        $auditionId = $get('audition_id');
                        return AuditionSlot::query()
                            ->where('audition_id', $auditionId)
                            ->get()
                            ->mapWithKeys(fn (AuditionSlot $slot) => [
                                $slot->id => $slot->time->format('h:i A')
                            ]);
                    })
                    ->disabled(fn (callable $get) => !$get('audition_id'))
                    ->required()
                    ->reactive(),
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
                Forms\Components\TextInput::make('payment_order_id')
                    ->maxLength(191),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->required()
                    ->default('pending'),
                
                Forms\Components\Checkbox::make('agreed_terms')
                    ->default(true)
                    ->required()
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

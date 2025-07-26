<?php

namespace App\Filament\Resources\AuditionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlotsRelationManager extends RelationManager
{
    protected static string $relationship = 'slots';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('time')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('max_participants')
                    ->numeric()
                    ->default(4)
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('time')
            ->modifyQueryUsing(function (Builder $query) {
                $query->withCount('registrations');
            })
            ->columns([
                Tables\Columns\TextColumn::make('time')
                    ->time('h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('registrations_count')
                    ->label('Registrations')
                    ->counts('registrations'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create slot')
                    ->modalWidth('sm'),
                Tables\Actions\Action::make('create_many')
                    ->label('Create Many')
                    ->modalWidth('md')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\TimePicker::make('start_time')
                            ->required()
                            ->default(fn($record) => $this->ownerRecord->start->format('h:i A'))
                            ->label('Start Time')
                            ->seconds(false),
                        Forms\Components\TimePicker::make('end_time')
                            ->required()
                            ->label('End Time')
                            ->seconds(false),
                        Forms\Components\TextInput::make('interval')
                            ->numeric()
                            ->default(5)
                            ->required()
                            ->label('Interval (in minutes)')
                    ])
                    ->action(function (array $data) {
                        $startTime = \Carbon\Carbon::parse($data['start_time']);
                        $endTime = \Carbon\Carbon::parse($data['end_time']);
                        $interval = $data['interval'];

                        while ($startTime < $endTime) {
                            $this->ownerRecord->slots()->create([
                                'time' => $startTime->format('H:i'),
                                'max_participants' => 4
                            ]);

                            $startTime->addMinutes($interval);
                        }

                        Notification::make()
                            ->title('Slots Created')
                            ->body('Slots have been created successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-users')
                    ->modalHeading('Registration for this slot')
                    ->modalContent(function ($record) {
                        $registrations = $record->registrations;

                        return view('filament.resources.audition-resource.relation-managers.slots-relation-manager.slot-registration', [
                            'registrations' => $registrations,
                        ]);
                    }),
                Tables\Actions\EditAction::make()
                    ->modalWidth('sm'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

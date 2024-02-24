<?php

namespace App\Filament\Admin\Pages;

use App\Models\Club;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ClubSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Club $club_model;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.club-settings';

    public function mount(): void
    {
        $club = Cache::get('club.' . auth()->user()->club_id);
        if (!$club) $club = Club::find(auth()->user()->club_id)->toArray();
        $this->form->fill($club);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
//                        SpatieMediaLibraryFileUpload::make('logo'),

                        FileUpload::make('logo')->directory('logos'),
                        TextInput::make('name')->required()->maxLength(50),
                        TextInput::make('official_name')->required()->maxLength(50),
                    ]),
                    Section::make([
                        TextInput::make('address')->required()->maxLength(50),
                        TextInput::make('web_page')->required()->maxLength(50),
                        TextInput::make('id_number')->required()->maxLength(50),
                        TextInput::make('established_at')->numeric()->required(),
                    ])->grow(false),
                ])->from('md')
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $form = $this->form->getState();

            auth()->user()->club->update($form);
            $data = auth()->user()->club->toArray();

            Cache::forever("club." . auth()->user()->club_id, $data);
            Cache::forever("club." . $data['slug'], $data);

            Notification::make()
                ->title(__('Updated successfully'))
                ->success()
                ->send();
        } catch (Halt $exception) {
            Notification::make()
                ->title(__('Error'))
                ->danger()
                ->send();
            return;
        }
    }
}

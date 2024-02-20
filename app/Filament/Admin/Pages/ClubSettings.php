<?php

namespace App\Filament\Admin\Pages;

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

class ClubSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.club-settings';

    public function mount(): void
    {
        $this->form->fill(Cache::get('club.' . auth()->user()->club_id));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        FileUpload::make('logo')->directory('logos'),
                        TextInput::make('name')->required(),
                        TextInput::make('official_name')->required(),
                    ]),
                    Section::make([
                        TextInput::make('address')->required(),
                        TextInput::make('web_page')->required(),
                        TextInput::make('id_number')->required(),
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
            $data = $this->form->getState();

            auth()->user()->club->update($data);

            Cache::forever("club." . auth()->user()->id, $data);

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

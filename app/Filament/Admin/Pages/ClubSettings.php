<?php

namespace App\Filament\Admin\Pages;

use App\Forms\Components\MySpatieUpload;
use App\Models\Club;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
    protected static ?string $title = 'Postavke Kluba';
    public static ?string $navigationLabel = 'Postavke Kluba';

    protected static ?string $navigationGroup = 'Postavke';

    protected static ?string $navigationIcon = 'heroicon-s-cog-6-tooth';

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
                        FileUpload::make('logo')->directory('logos')->imagePreviewHeight('200'),
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
//            if ($this->data['logo']) {
//                auth()->user()->club->addMedia($this->data['logo'][array_key_first($this->data['logo'])]->getRealPath())->toMediaCollection('logos');
//            }

            $data = auth()->user()->club->toArray();

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

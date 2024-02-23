<?php

namespace App\Filament\Admin\Pages;

use App\Models\Club;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class Login extends \Filament\Pages\Auth\Login
{
    public function mount(): void
    {
        $this->data['clubTenant'] = null;
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $host = explode('.' . config('app.domain'), $_SERVER['HTTP_HOST']);

//        if (str_contains($_SERVER['HTTP_HOST'], '.' . config('app.domain')) and $host[0]) {
//            $club = Cache::get("club.{$host[0]}") ?: Club::where('slug', $host[0])->first()->toArray();
//
//            if ($club) {
//                Cache::forever("club.{$host[0]}", $club);
//                Cache::forever("club.{$club['id']}", $club);
//                $this->data['clubTenant'] = $host[0];
//            }
//        }

        $this->form->fill();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (!$user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}

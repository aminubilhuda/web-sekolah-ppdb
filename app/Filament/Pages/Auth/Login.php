<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('login')
                    ->label('Email atau Username')
                    ->required()
                    ->autocomplete()
                    ->autofocus(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
                Checkbox::make('remember')
                    ->label('Ingat saya'),
            ]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'login' => __('filament-panels::pages/auth/login.messages.throttled', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $data = $this->form->getState();

        $fieldType = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! auth()->attempt([
            $fieldType => $data['login'],
            'password' => $data['password'],
        ], $data['remember'])) {
            throw ValidationException::withMessages([
                'login' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        return app(LoginResponse::class);
    }
} 
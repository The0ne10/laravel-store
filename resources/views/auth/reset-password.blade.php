@extends('layouts.auth')

@section('title', 'Востановление пароля')

@section('content')
    <x-forms.auth-forms
        title="Востановление пароля"
        action="{{ route('password.update') }}"
        method="POST"
    >
        @csrf

        <input type="hidden" name="token" value="{{ $token }}" />
        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
            :is-error="$errors->has('email')"
            value="{{ request('email') }}"
        />
        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password"
            type="password"
            placeholder="Пароль"
            required="true"
            :is-error="$errors->has('password')"
        />
        @error('password')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password_confirmation"
            type="password"
            placeholder="Подтверждение пароля"
            required="true"
            :is-error="$errors->has('password_confirmation')"
        />
        @error('password_confirmation')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Обновоить пароль
        </x-forms.primary-button>

        <x-slot:socialAuth>

        </x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}"
                                                    class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a>
                </div>
            </div>
        </x-slot:buttons>
    </x-forms.auth-forms>
@endsection

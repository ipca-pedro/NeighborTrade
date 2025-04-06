<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome Completo -->
        <div>
            <x-input-label for="Name" :value="__('Nome Completo')" />
            <x-text-input id="Name" class="block mt-1 w-full" type="text" name="Name" :value="old('Name')" required autofocus />
            <x-input-error :messages="$errors->get('Name')" class="mt-2" />
        </div>

        <!-- Nome de Usuário -->
        <div class="mt-4">
            <x-input-label for="User_Name" :value="__('Nome de Usuário')" />
            <x-text-input id="User_Name" class="block mt-1 w-full" type="text" name="User_Name" :value="old('User_Name')" required />
            <x-input-error :messages="$errors->get('User_Name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="Email" :value="__('Email')" />
            <x-text-input id="Email" class="block mt-1 w-full" type="email" name="Email" :value="old('Email')" required />
            <x-input-error :messages="$errors->get('Email')" class="mt-2" />
        </div>

        <!-- Data de Nascimento -->
        <div class="mt-4">
            <x-input-label for="Data_Nascimento" :value="__('Data de Nascimento')" />
            <x-text-input id="Data_Nascimento" class="block mt-1 w-full" type="date" name="Data_Nascimento" :value="old('Data_Nascimento')" required />
            <x-input-error :messages="$errors->get('Data_Nascimento')" class="mt-2" />
        </div>

        <!-- CC -->
        <div class="mt-4">
            <x-input-label for="CC" :value="__('Cartão de Cidadão')" />
            <x-text-input id="CC" class="block mt-1 w-full" type="number" name="CC" :value="old('CC')" required />
            <x-input-error :messages="$errors->get('CC')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="Password" :value="__('Password')" />
            <x-text-input id="Password" class="block mt-1 w-full" type="password" name="Password" required />
            <x-input-error :messages="$errors->get('Password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Já tem conta?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

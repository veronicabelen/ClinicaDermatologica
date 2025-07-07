<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create una Cuenta')" :description="__('Ingrese sus datos a continuación para crear su cuenta')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Nombre')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Apellido')" />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Correo Electronico')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Contraseña')"
            viewable />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmar Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmar contraseña')"
            viewable />

        <div class="flex items-center justify-end">
            {{-- Botón "Crear Cuenta" en rosa --}}
            <flux:button type="submit" variant="primary" class="w-full bg-pink-600 hover:bg-pink-700 text-white rounded-md">
                {{ __('Crear Cuenta') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('¿Usted ya posee una cuenta?') }}
        {{-- Enlace "Iniciar Sesión" estilizado como botón rosa --}}
        <flux:link :href="route('login')" wire:navigate
            class="inline-block px-6 py-2 bg-pink-600 text-white hover:bg-pink-700 rounded-md font-semibold transition-colors duration-200">
            {{ __('Iniciar Sesión') }}
        </flux:link>
    </div>
</div>
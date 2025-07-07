<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Inicia sesión en tu cuenta')" :description="__('Ingrese su correo electrónico y contraseña a continuación para iniciar sesión')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Correo Electronico')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable />

            @if (Route::has('password.request'))
            <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                {{ __('¿Olvidaste tú contraseña?') }}
            </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Recordarme')" />

        <div class="flex items-center justify-end">
            {{-- Botón "Iniciar Sesión" en rosa --}}
            <flux:button variant="primary" type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white rounded-md">
                {{ __('Iniciar Sesión') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('¿Usted no posee una cuenta?') }}
        {{-- Enlace "Registración" estilizado como botón rosa --}}
        <flux:link :href="route('register')" wire:navigate
            class="inline-block px-6 py-2 bg-pink-600 text-white hover:bg-pink-700 rounded-md font-semibold transition-colors duration-200">
            {{ __('Registración') }}
        </flux:link>
    </div>
    @endif
</div>
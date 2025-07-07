<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\livewire\Admin\TurnosAdmin;
use App\Livewire\Admin\UsuariosAdmin;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\TratamientoController;

Route::resource('medicos', MedicoController::class);
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/mis-turnos', [App\Http\Controllers\MisTurnosController::class, 'index'])->name('mis-turnos');
    
    Route::get('/reservar-turno', [App\Http\Controllers\MisTurnosController::class, 'ReservarTurno'])->name('reservar-turno');
    Route::post('/reservar-turno', [App\Http\Controllers\MisTurnosController::class, 'store'])->name('turnos.store');

    Route::delete('/mis-turnos/{turno}', [App\Http\Controllers\MisTurnosController::class, 'destroy'])->name('turno-eliminar');

    // Rutas para la gestión de médicos
    Route::middleware(['auth'])->group(function () { // Opcional: proteger estas rutas con autenticación
    Route::get('/medicos-registrados', [App\Http\Controllers\MedicoController::class, 'index'])->name('medicos-registrados');
    //Route::post('/medicos-registrados', [App\Http\Controllers\MedicoController::class, 'store'])->name('medicos.store');
    });

    //ruta medicos
     Route::get('/medicos-registrados', [App\Http\Controllers\MedicoController::class, 'index'])->name('medicos-registrados');

     //ruta tratamientos
     Route::get('/tratamientos-disponibles', [App\Http\Controllers\TratamientoController::class, 'index'])->name('tratamientos-disponibles');

});


Route::middleware(['rol:admin'])->group(function () {
    // Rutas solo para admin
});

Route::middleware(['auth', 'can:admin'])->group(function () {
});

require __DIR__.'/auth.php';
Route::middleware(['auth', 'can:admin, App\\Models\\User'])->group(function () {
Route::get('/admin/turnos', TurnosAdmin::class)->name('admin.turnos');
Route::get('/admin/usuarios', UsuariosAdmin::class)->name('admin.usuarios');
});
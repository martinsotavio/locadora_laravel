<?php

use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ClienteController; 

Route::view('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
    });


Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
    

    // Criar / Salvar
    Route::get('/clientes/novo', [ClienteController::class, 'criar'])->name('clientes.criar');
    Route::post('/clientes/salvar', [ClienteController::class, 'salvar'])->name('clientes.salvar');

    // Listar
    Route::get('/clientes', [ClienteController::class, 'listar'])->name('clientes.listar');

    // Editar / Atualizar
    Route::get('/clientes/{id}/editar', [ClienteController::class, 'editar'])->name('clientes.editar');
    Route::post('/clientes/{id}/atualizar', [ClienteController::class, 'atualizar'])->name('clientes.atualizar');

    // Deletar
    Route::delete('/clientes/{id}/deletar', [ClienteController::class, 'deletar'])->name('clientes.deletar');
});

require __DIR__.'/settings.php';
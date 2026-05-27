<?php

use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\LocacaoController;

Route::view('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('team.dashboard');
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

    // Funcionários
    Route::get('/funcionarios/novo', [FuncionarioController::class, 'criar'])->name('funcionarios.criar');
    Route::post('/funcionarios/salvar', [FuncionarioController::class, 'salvar'])->name('funcionarios.salvar');
    Route::get('/funcionarios', [FuncionarioController::class, 'listar'])->name('funcionarios.listar');
    Route::get('/funcionarios/{id}/editar', [FuncionarioController::class, 'editar'])->name('funcionarios.editar');
    Route::post('/funcionarios/{id}/atualizar', [FuncionarioController::class, 'atualizar'])->name('funcionarios.atualizar');
    Route::delete('/funcionarios/{id}/deletar', [FuncionarioController::class, 'deletar'])->name('funcionarios.deletar');

    // Locações
    Route::get('/locacoes/novo', [LocacaoController::class, 'criar'])->name('locacoes.criar');
    Route::post('/locacoes/salvar', [LocacaoController::class, 'salvar'])->name('locacoes.salvar');
    Route::get('/locacoes', [LocacaoController::class, 'listar'])->name('locacoes.listar');
    Route::get('/locacoes/{id}/editar', [LocacaoController::class, 'editar'])->name('locacoes.editar');
    Route::post('/locacoes/{id}/atualizar', [LocacaoController::class, 'atualizar'])->name('locacoes.atualizar');
    Route::delete('/locacoes/{id}/deletar', [LocacaoController::class, 'deletar'])->name('locacoes.deletar');
});

require __DIR__.'/settings.php';
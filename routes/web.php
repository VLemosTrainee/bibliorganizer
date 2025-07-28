<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\LivrosIndex;
use App\Livewire\AutorIndex;
use App\Livewire\EditoraIndex;
use App\Livewire\MontraLivros;
use App\Livewire\GestaoUtilizadores;
use App\Livewire\MinhasRequisicoes;
use App\Livewire\GestaoRequisicoes;
use App\Exports\LivrosExport;
use App\Exports\AutoresExport;
use App\Exports\EditorasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\ConfirmarDevolucaoPagina;
use App\Livewire\EditarUtilizadorPagina;
use Illuminate\Support\Facades\Mail;

// A rota 'requisicao.criar' está comentada, o que é ótimo, pois já não a usamos.
// use App\Livewire\CriarRequisicao;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ROTA PÚBLICA / PÁGINA INICIAL
Route::get('/', MontraLivros::class)->name('home');


// ROTAS AUTENTICADAS
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Páginas de Gestão Abertas a todos os utilizadores logados
    Route::get('/livros', LivrosIndex::class)->name('livros.index');

    // ================================================================
    // ROTAS PROTEGIDAS APENAS PARA ADMINS
    // ================================================================
    Route::middleware(['admin'])->group(function () {
        Route::get('/autores', AutorIndex::class)->name('autores.index');
        Route::get('/editoras', EditoraIndex::class)->name('editoras.index');
        Route::get('/gestao/utilizadores', GestaoUtilizadores::class)->name('utilizadores.index');
        Route::get('/gestao/requisicoes', GestaoRequisicoes::class)->name('requisicoes.admin');
        Route::get('/gestao/requisicoes/{requisicao}/devolver', ConfirmarDevolucaoPagina::class)
     ->name('requisicoes.devolver');
        Route::get('/gestao/utilizadores/{user}/editar', EditarUtilizadorPagina::class)
     ->name('utilizadores.editar');
        Route::get('/minhas-requisicoes', MinhasRequisicoes::class)->name('requisicoes.minhas');

        // Rotas de Exportação de Admin
        Route::get('/autores/exportar', function () {
            // ...
        })->name('autores.export');

        Route::get('/editoras/exportar', function () {
            // ...
        })->name('editoras.export');
    });
    
    // ================================================================
    // ROTA ESPECÍFICA DO CIDADÃO
    // ================================================================
    Route::get('/minhas-requisicoes', MinhasRequisicoes::class)->name('requisicoes.minhas');
    
    // Rota de Exportação aberta a todos os logados (se aplicável)
    Route::get('/livros/exportar', function () {
        // ...
    })->name('livros.export');
    
});
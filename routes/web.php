<?php

use App\Exports\LivrosExport;
use App\Exports\AutoresExport;
use App\Exports\EditorasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\LivrosIndex;
use App\Livewire\AutorIndex;
use App\Livewire\EditoraIndex;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Rotas de Páginas
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/livros', LivrosIndex::class)->name('livros.index');
    Route::get('/autores', AutorIndex::class)->name('autores.index');
    Route::get('/editoras', EditoraIndex::class)->name('editoras.index');

    // Rota de Exportação de Livros (COM A SINTAXE CORRETA)
    Route::get('/livros/exportar', function () {
        $idsString = request()->query('ids', '');
        $ids = !empty($idsString) ? explode(',', $idsString) : [];
        $nomeFicheiro = 'BookOrganizer_' . now()->format('Y-m-d_Hisv') . '.xlsx';
        return Excel::download(new LivrosExport($ids), $nomeFicheiro);
    })->name('livros.export');
    
    // Rota de Exportação de Autores
    Route::get('/autores/exportar', function () {
        $idsString = request()->query('ids', '');
        $ids = !empty($idsString) ? explode(',', $idsString) : [];
        $nomeFicheiro = 'BookOrganizer_Autores_' . now()->format('Y-m-d_Hisv') . '.xlsx';
        return Excel::download(new AutoresExport($ids), $nomeFicheiro);
    })->name('autores.export');

    // Rota de Exportação de Editoras
    Route::get('/editoras/exportar', function () {
        $idsString = request()->query('ids', '');
        $ids = !empty($idsString) ? explode(',', $idsString) : [];
        $nomeFicheiro = 'BookOrganizer_Editoras_' . now()->format('Y-m-d_Hisv') . '.xlsx';
        return Excel::download(new EditorasExport($ids), $nomeFicheiro);
    })->name('editoras.export');

});
<?php

use App\Http\Controllers\DemandaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedidaController;
use App\Http\Controllers\MedidaObservacaoController;
use App\Http\Controllers\OrigemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ViolenciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedidaDocumentoController;

Route::get('/', function () {return view('auth.login');});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('unidades', App\Http\Controllers\UnidadeController::class);

    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::resource('pessoas', App\Http\Controllers\PessoaController::class);

    //Medidas
    Route::resource('medidas', MedidaController::class);
    Route::post('medidas/{medida}/observacao', [MedidaController::class, 'storeObservacao'])->name('medidas.observacao.store');
    Route::post('medidas/{medida}/documento', [MedidaController::class, 'storeDocumento'])->name('medidas.documento.store');
    Route::get('medidas/documento/{documento}/download', [MedidaController::class, 'downloadDocumento'])->name('medidas.documento.download');
    Route::put('medidas/{medida}/desligar', [MedidaController::class, 'desligar'])->name('medidas.desligar');
    Route::delete('medidas/observacao/{observacao}', [MedidaObservacaoController::class, 'destroy'])->name('medidas.observacao.destroy');

    //Documentos
    Route::get('documentos/{documento}/download', [MedidaDocumentoController::class, 'download'])->name('documentos.download');
    Route::delete('documentos/{documento}', [MedidaDocumentoController::class, 'destroy'])->name('documentos.destroy');

    Route::resource('violencias', ViolenciaController::class);

    Route::resource('origens', OrigemController::class)->parameters(['origens' => 'origem']);

    Route::resource('tipos', TipoController::class);

    Route::resource('demandas', DemandaController::class);

});



require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\AdmLivroController;
use App\Http\Controllers\AdmUsuarioController;
use App\Http\Controllers\AdmEmprestimoController;

//Route::get('/', IndexController::class);

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\EmprestimoController;

use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\AuthController;

Route::group(['middleware' => ['auth', 'verified']], function() {

    Route::middleware('autenticar.adm')->name('adm.')->prefix('adm')->group(function () {
        Route::get('/', AdmController::class)->name('index');
        Route::resource('/livros', AdmLivroController::class)->except([
           'create'
        ]);
        Route::resource('/emprestimos', AdmEmprestimoController::class)->except([
            'create', 'edit', 'show', 'update'
        ]);
        Route::put('/emprestimos/{id}/{status}', [AdmEmprestimoController::class, 'update'])->name('emprestimos.update');
        Route::get('/usuarios', [AdmUsuarioController::class, 'index'])->name('usuarios');
        Route::delete('/usuarios/{id}', [AdmUsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::put('/give_adm/{id}/{give}', [AdmUsuarioController::class, 'giveAdm'])->name('usuarios.giveAdm');
    });
    
    Route::name('verification.')->controller(VerificationController::class)->group(function (){
        Route::get('/email/verificar', 'show')->name('notice');
        Route::get('/email/verificar/{id}/{hash}', 'verify')->name('verify')->middleware(['signed']);
        Route::post('/email/reenviar', 'resend')->name('resend');
    });


    Route::controller(LivroController::class)->group(function () {
        Route::get('/livros', 'index')->name('livros.index');
        Route::get('/livros/{livro}', 'livro')->name('livros.show');
    });

    Route::get('/', IndexController::class)->name('index');
    Route::get('/emprestimos', [EmprestimoController::class, 'index'])->name('emprestimos.index');
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/emprestimos', [EmprestimoController::class, 'store'])->name('emprestimos.store');
});

Auth::routes(['verify' => true ]);

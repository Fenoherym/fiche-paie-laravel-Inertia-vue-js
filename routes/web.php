<?php

use App\Http\Controllers\CongeController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkplaceController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/personnels', 'App\Http\Controllers\PersonnelController@index')->name('personnel.index');
    Route::get('/personnel/create', 'App\Http\Controllers\PersonnelController@create');
    Route::get('/personnel/edit/{id}', 'App\Http\Controllers\PersonnelController@edit');
    Route::post('/personnel/store', 'App\Http\Controllers\PersonnelController@store');
    Route::post('/personnel/update/{id}', 'App\Http\Controllers\PersonnelController@update');
    Route::get('personnel/delete/{id}', 'App\Http\Controllers\PersonnelController@destroy');

    Route::post('/personnel/excel/import', 'App\Http\Controllers\PersonnelController@import');

    Route::get('/personnel/absences', 'App\Http\Controllers\AbsenceController@index')->name('absence.index');
    Route::post('/absence/create', 'App\Http\Controllers\AbsenceController@store');
    Route::post('/absence/update/{id}', 'App\Http\Controllers\AbsenceController@update');
    Route::get('/absence/{id}', 'App\Http\Controllers\AbsenceController@destroy');

    Route::get('/paies', 'App\Http\Controllers\PaieController@index')->name('paie.index');
    Route::get('/paie/create', 'App\Http\Controllers\PaieController@create');
    Route::get('/paie/generate', 'App\Http\Controllers\PaieController@generatePaie');
    Route::get('/paie/edit/{id}', 'App\Http\Controllers\PaieController@edit');
    Route::delete('/paies/delete/month', 'App\Http\Controllers\PaieController@deletePaiesMonth');
    Route::get('/paie/delete/{id}', 'App\Http\Controllers\PaieController@destroy');
    Route::get('/paie/{id}', 'App\Http\Controllers\PaieController@show')->name('paie.show');
    Route::post('/paie/store', 'App\Http\Controllers\PaieController@store');
    Route::post('/paie/update/{id}', 'App\Http\Controllers\PaieController@update');

    Route::get('/rubriques', 'App\Http\Controllers\RubriqueController@index')->name('rubrique.index');
    Route::get('/rubrique/create', 'App\Http\Controllers\RubriqueController@create')->name('rubrique.create');
    Route::post('/rubrique/store', 'App\Http\Controllers\RubriqueController@store')->name('rubrique.store');
    Route::get('/rubrique/delete/{id}', 'App\Http\Controllers\RubriqueController@destroy')->name('rubrique.destroy');
    Route::get('/rubrique/edit/{id}', 'App\Http\Controllers\RubriqueController@edit')->name('rubrique.edit');
    Route::post('/rubrique/update/{id}', 'App\Http\Controllers\RubriqueController@update')->name('rubrique.update');
    Route::post('/irsas/update', 'App\Http\Controllers\IrsaController@update')->name('irsa.update');


    Route::get('/conges', [CongeController::class, 'index'])->name('conge.index');
    Route::get('/conge/edit/{id}', [CongeController::class, 'edit'])->name('conge.edit');
    Route::get('/conge/delete/{id}', [CongeController::class, 'destroy'])->name('conge.destroy');
    Route::post('/conge/store', [CongeController::class, 'store'])->name('conge.store');
    Route::post('/conge/update/{id}', [CongeController::class, 'update'])->name('conge.update');

    Route::get('/conges/employe/ask', [CongeController::class, 'ask'])->name('conge.ask');
    Route::get('/conges/agree/{id}', [CongeController::class, 'agree'])->name('conge.agree');

    Route::get('/messages', [MessageController::class, 'index'])->name('message.index');
    Route::post('/message/send', [MessageController::class, 'store'])->name('message.store');
    Route::get('/message/delete/{id}', [MessageController::class, 'destroy'])->name('message.destroy');

    Route::get('/societe', [SocieteController::class, 'index'])->name('societe.index');
    Route::get('/societe/service/delete/{id}', [EstablishmentController::class, 'destroy'])->name('service.destroy');
    Route::get('/societe/workplace/delete/{id}', [WorkplaceController::class, 'destroy'])->name('workplace.destroy');
    Route::post('/societe/update/{id}', [SocieteController::class, 'update'])->name('societe.update');
    Route::post('/societe/service/update/{id}', [EstablishmentController::class, 'update'])->name('service.update');
    Route::get('/societe/service/create', [EstablishmentController::class, 'create'])->name('service.create');
    Route::post('/societe/service/store', [EstablishmentController::class, 'store'])->name('service.store');
    Route::post('/societe/workplace/store', [WorkplaceController::class, 'store'])->name('workplace.store');
    Route::post('/contrat/update', [ContratController::class, 'update'])->name('contrat.update');
    Route::post('/contrat/store', [ContratController::class, 'store'])->name('contrat.store');
    Route::get('/contrat/delete/{id}', [ContratController::class, 'destroy'])->name('contrat.delete');



    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/update-name', [ProfilController::class, 'update_name'])->name('profil.update.name');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::post('/logo/change', [SocieteController::class, 'changeLogo'])->name('logo.change');
});

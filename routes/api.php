<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacancyApplicationController;

Route::post('/vacantes/coordinadora', [VacancyApplicationController::class, 'submitCoordinator'])->name('vacantes.coordinadora.submit');
Route::post('/vacantes/gerente', [VacancyApplicationController::class, 'submitManager'])->name('vacantes.gerente.submit');
Route::post('/vacantes/subgerente', [VacancyApplicationController::class, 'submitSubManager'])->name('vacantes.subgerente.submit');
Route::post('/vacantes/vendedor-credito', [VacancyApplicationController::class, 'submitCreditSeller'])->name('vacantes.vendedor_credito.submit');

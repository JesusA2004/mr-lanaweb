<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacancyApplicationController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
})->name('home');

Route::get('/impulsa-tu-negocio', function () {
    return Inertia::render('ImpulsaNegocio'); 
})->name('impulsaNegocio');

Route::get('/impulsat', function () {
    return Inertia::render('Impulsat');
})->name('impulsat');

Route::get('/sucursales', function () {
    return Inertia::render('Sucursales'); 
})->name('sucursales');

Route::get('/faqs', function () {
    return Inertia::render('Faqs'); 
})->name('faqs');

Route::post('/vacantes/postular', [VacancyApplicationController::class, 'store'])
  ->name('vacancies.apply');



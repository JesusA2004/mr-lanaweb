<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacancyApplicationController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\FaqQuestionController;
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

Route::post('/faqs/preguntar', [FaqQuestionController::class, 'store'])
    ->name('faqs.preguntar');

Route::get('/aviso-de-privacidad', function () {
    return Inertia::render('AvisoPrivacidad');
})->name('avisoPrivacidad');

Route::get('/terminos-y-condiciones', function () {
    return Inertia::render('Terminos');
})->name('Terminos');

Route::get('/nosotros', function () {
    return Inertia::render('Nosotros');
})->name('nosotros');

Route::get('/credito-comadres', function () {
    return Inertia::render('CreditoComadres');
})->name('creditoComadres');

Route::post('/formularios/enviar', [PublicFormController::class, 'store'])
    ->name('public.forms.store');


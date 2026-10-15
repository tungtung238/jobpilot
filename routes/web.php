<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfferController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Candidats
    Route::resource('candidate', CandidateController::class);

    // Entreprises
    Route::resource('company', CompanyController::class);

    // Offres
    Route::resource('offer', OfferController::class);
});

require __DIR__.'/settings.php';

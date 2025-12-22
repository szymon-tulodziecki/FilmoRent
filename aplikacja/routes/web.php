<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;


use App\Livewire\KatalogSprzetu;
use App\Http\Controllers\KatalogController;

Route::get('/', KatalogSprzetu::class)->name('home');
Route::get('/sprzet/{id}', [KatalogController::class, 'show'])->name('sprzet.show');

Route::get('/test', [TestController::class, 'index'])->name('test');


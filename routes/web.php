<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('frontend.index');

Auth::routes();

Route::post('login-user', [LoginController::class, 'loginUser'])->name('login.user');
Route::post('register-user', [RegisterController::class, 'registerUser'])->name('register.user');
Route::post('password/forget-mail', [RegisterController::class, 'forgetPasswordMail'])->name('forget.password.mail');
Route::get('set-forget-password', [RegisterController::class, 'setForgetPassword'])->name('set.forget.Password');
Route::post('set-forget-password', [RegisterController::class, 'setPassword'])->name('set.forget.Password');

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // country crude
    Route::get('country', [CountryController::class, 'index'])->name('country');
    Route::get('country-data', [CountryController::class, 'countryData'])->name('country.data');
    Route::post('country/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('country/{id}/edit', [CountryController::class, 'edit'])->name('country.edit');
    Route::post('country/{id}/update', [CountryController::class, 'update'])->name('country.update');
    Route::get('country/{id}/delete', [CountryController::class, 'delete'])->name('country.delete');

    // state crude
    Route::get('state', [StateController::class, 'index'])->name('state');
    Route::get('state-data', [StateController::class, 'stateData'])->name('state.data');
    Route::post('state/store', [StateController::class, 'store'])->name('state.store');
    Route::get('state/{id}/edit', [StateController::class, 'edit'])->name('state.edit');
    Route::post('state/{id}/update', [StateController::class, 'update'])->name('state.update');
    Route::get('state/{id}/delete', [StateController::class, 'delete'])->name('state.delete');

    // state crude
    Route::get('city', [CityController::class, 'index'])->name('city');
    Route::get('city-data', [CityController::class, 'cityData'])->name('city.data');
    Route::post('city/store', [CityController::class, 'store'])->name('city.store');
    Route::get('city/{id}/edit', [CityController::class, 'edit'])->name('city.edit');
    Route::post('city/{id}/update', [CityController::class, 'update'])->name('city.update');
    Route::get('city/{id}/delete', [CityController::class, 'delete'])->name('city.delete');
});

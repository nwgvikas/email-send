<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/login', '/backoffice/login');

Route::prefix('backoffice')->group(function () {
    Auth::routes();
});

Route::middleware('auth')->prefix('backoffice')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::post('/contacts/import', [ContactController::class, 'import'])->name('contacts.import');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');

    Route::get('/templates', [EmailTemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [EmailTemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}', [EmailTemplateController::class, 'show'])->name('templates.show');
    Route::get('/templates/{template}/edit', [EmailTemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/templates/{template}', [EmailTemplateController::class, 'update'])->name('templates.update');

    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::post('/campaigns/{campaign}/send', [CampaignController::class, 'sendNow'])->name('campaigns.send');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
});

Route::redirect('/home', '/backoffice/dashboard');

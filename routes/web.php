<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\YampiWebhookController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de produtos
    Route::resource('products', ProductController::class);

    // Rotas de integrações
    Route::resource('integrations', IntegrationController::class);
    Route::post('/integrations/test', [IntegrationController::class, 'test'])->name('integrations.test');

    // Webhook da Yampi
    Route::post('/webhooks/yampi', [YampiWebhookController::class, 'handle'])
        ->name('webhooks.yampi')
        ->middleware('auth');
});

// Rota para mudança de idioma
Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');

require __DIR__.'/auth.php';

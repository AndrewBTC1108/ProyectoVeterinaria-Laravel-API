<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HoursPetsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\MedicalHistoriesController;
use App\Http\Controllers\VaccinesDewormingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group( function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [LoginController::class, 'destroy']);

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['throttle:6,1'])
                ->name('verification.send');

    Route::put('/password', [PasswordController::class, 'update']);
    //el metodo patch es para cuando se va hacer la modificacion o actualizar mas de un dato del modelo
    Route::patch('/profile', [ProfileController::class, 'update']);
    //categories of sidebar
    Route::get('/categorias', [CategoriesController::class, 'index']);
    Route::get('/admin-categories', [CategoriesController::class, 'adminCategories']);
    Route::get('/doctor-categories', [CategoriesController::class, 'doctorCategories']);

    Route::apiResource('/pets', PetsController::class);

    Route::apiResource('/appointments', AppointmentsController::class);
    Route::apiResource('/medicalHistories', MedicalHistoriesController::class);

    //obtener horas y mascotas
    Route::get('/hours', [HoursPetsController::class, 'hours']);
    Route::get('/availablePets', [HoursPetsController::class, 'pets']);

    //Vacinnes and Dewormings
    Route::get('/petsVD', [VaccinesDewormingsController::class, 'index']);
    Route::post('/petsVD/vaccine', [VaccinesDewormingsController::class, 'createVaccine']);
    Route::post('/petsVD/deworming', [VaccinesDewormingsController::class, 'createDeworming']);

    //obtener los usuarios
    //solo algunas rutas necesitan un límite de solicitudes más alto se pueden excluir estas rutas del middleware
    //el middleware indica que se permiten hasta 100 solicitudes por minuto. solo para esta ruta
    Route::get('/users', UsersController::class)->middleware('throttle:100,1');

});
//access to this route does not require authentication.
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::middleware('guest')->group(function() {

    Route::post('/login', [LoginController::class, 'store'])
                ->name('login');

    Route::post('/register', [RegisteredUserController::class, 'store'])
                ->name('register');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

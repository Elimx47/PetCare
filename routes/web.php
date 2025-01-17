<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdoptionController;


Route::get('/', [UserController::class, 'welcome'])->name('welcome');

Route::middleware('isUserOrGuest')->group(function () {


    Route::get('/about', [UserController::class, 'about'])->name('about');

    Route::get('/contact', [UserController::class, 'contact'])->name('contact');
});

//User routes
Route::middleware('isUser:user')->group(function () {

    Route::get('/adopt-pet', [PetController::class, 'index'])->name('pet-adopt');

    Route::get('/medication-page', [UserController::class, 'medicationPage'])->name('medication');

    Route::get('/pets/{id}/details', [PetController::class, 'show'])->name('pets.show');

    Route::post('pets/user-store', [PetController::class, 'store'])->name('user-store.post');

    Route::get('/user-add-pet', [PetController::class, 'userAdd'])->name('userAddPet');

    Route::get('/user/profile/pog', [UserController::class, 'profile'])->name('userProfile');

    Route::get('/my-pets', [PetController::class, 'userPets'])->name('userPets');

    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password')->middleware('auth');

    Route::post('/submit-adoption', [AdoptionController::class, 'submit'])->name('submit.adoption');

    Route::get('/adoption-application', [AdoptionController::class, 'viewAdoptionApplications'])->name('user.adoption.applications');

    Route::delete('/adoption-applications/{id}/cancel', [AdoptionController::class, 'cancelApplication'])
        ->name('adoption.cancel');

    Route::get('/user/edit-pet/{id}', [PetController::class, 'userEdit'])->name('userEditPet');
    Route::put('/user/update-pet/{id}', [PetController::class, 'userUpdate'])->name('user-update-pet');


    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');

    Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/order/{id}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('user.orders');
});

// Admin routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isAdmin:admin',
])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('manage-medication', [AdminController::class, 'manageMedication'])->name('medication-manage');

    Route::get('manage-pet', [PetController::class, 'manage'])->name('pet-manage');

    Route::get('manage-users', [AdminController::class, 'manageUsers'])->name('users-manage');

    Route::get('/pets/{id}', [PetController::class, 'adminShow'])->name('admin-pets.show');

    Route::get('admin-add-pet', [PetController::class, 'adminAdd'])->name('adminAddPet');

    Route::post('pets/admin-store', [PetController::class, 'store'])->name('store.post');

    Route::delete('/pet/delete/{id}', [PetController::class, 'destroy'])->name('adminDeletePet');

    Route::get('/pets/{id}/edit', [PetController::class, 'adminEdit'])->name('adminEditPet');

    Route::get('/admin/archived-pets', [PetController::class, 'archivedPets'])->name('archivedPets');

    Route::patch('/admin/pets/{id}/restore', [PetController::class, 'restorePet'])->name('adminRestorePet');

    Route::delete('/admin/pets/{id}/permanent-delete', [PetController::class, 'permanentDeletePet'])->name('adminPermanentDeletePet');

    Route::put('/pets/{id}/edit-pet', [PetController::class, 'update'])->name('adminUpdatePet');

    Route::patch('/admin/pet/{id}/approve', [PetController::class, 'approvePet'])->name('admin.pet.approve');
    Route::patch('/admin/pet/{id}/reject', [PetController::class, 'rejectPet'])->name('admin.pet.reject');

    Route::get('/admin/users/{id}', [AdminController::class, 'showUserDetails'])->name('userDetails');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

    Route::get('/user', [UserController::class, 'index']);

    Route::get('/create', [UserController::class, 'create']);

    Route::get('/admin/manage-adoptions', [AdoptionController::class, 'manageAdoptions'])
        ->name('admin.adoption.manage');

    Route::patch('/admin/adoptions/{id}/approve', [AdoptionController::class, 'approveAdoption'])
        ->name('admin.adoption.approve');

    Route::patch('/admin/adoptions/{id}/reject', [AdoptionController::class, 'rejectAdoption'])
        ->name('admin.adoption.reject');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');

    Route::patch('/admin/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.update-status');
});

Route::get('/home', [LoginController::class, 'index'])->name('home');

Route::fallback(function () {
    abort(404);
});

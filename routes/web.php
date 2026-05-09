<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\PaymentCallbackController;
use App\Http\Controllers\User\ProfileController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $books = Book::where('stock', '>=', '1')->get();
    return view('landing', compact('books'));
})->name('landing');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

Route::get('/register', [RegisterController::class, 'index'])->name('register.create');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.index');

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('orders', OrderController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('report.index');
});

// User Routes
Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user', 'as' => 'user.'], function () {

    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard.index');
    Route::get('books', [HomeController::class, 'books'])->name('book.index');
    Route::get('orders', [UserOrderController::class, 'index'])->name('order.index');
    Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about-us');

    Route::get('carts', [CartController::class, 'index'])->name('cart.index');
    Route::post('carts', [CartController::class, 'store'])->name('cart.store');
    Route::delete('carts/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.store');
    Route::get('orders/{id}/pay', [UserOrderController::class, 'payment'])->name('order.pay');
    Route::put('orders/{id}/cancel', [UserOrderController::class, 'cancel'])->name('order.cancel');

    Route::put('profile/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');

    Route::post('/payment/callback', [PaymentCallbackController::class, 'callback']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/invoices/{orderNumber}', [InvoiceController::class, 'show'])->name('invoices.order.show');
    Route::get('/invoices/{orderNumber}/download', [InvoiceController::class, 'download'])->name('invoices.order.download');
});

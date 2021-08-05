<?php 

use Illuminate\Support\Facades\Route;
// bukan coba fi di webnya
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');

Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [App\Http\Controllers\DetailController::class, 'add'])->name('detail-add');

// Route::post('/checkout/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::post('/payment/handling', 'CheckoutController@callback');
Route::get('/payment/cancel', 'CheckoutController@midtranscancel');
Route::get('/payment/finish', 'CheckoutController@midtransfinish');
Route::get('/payment/unfinish', 'CheckoutController@midtransunfinish');
Route::get('/payment/error', 'CheckoutController@midtranserror');

Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])->name('success');
Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])->name('register-success');

Route::get('/failed', [App\Http\Controllers\CartController::class, 'failed'])->name('failed');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::post('/search', [App\Http\Controllers\SearchController::class, 'redirect'])->name('search-redirect');
Route::get('/search/{slug}', [App\Http\Controllers\SearchController::class, 'query'])->name('search-query');


Route::group(['middleware' => ['auth']], function(){
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])
    ->name('cart');
    Route::post('/cart/{id}', [App\Http\Controllers\CartController::class, 'update']);
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])
    ->name('cart-delete');

    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])
    ->name('checkout');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard');

    Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])
    ->name('dashboard-transaction');
    Route::get('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'details'])
    ->name('dashboard-transaction-details');
    Route::post('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'update'])
    ->name('dashboard-transaction-update');

    Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])
    ->name('dashboard-account');
    Route::post('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardSettingController::class, 'update'])
    ->name('dashboard-account-redirect');

});

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth','admin'])   
    ->group(function() {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');
        Route::resource('category','\App\Http\Controllers\Admin\CategoryController');
        Route::resource('user','\App\Http\Controllers\Admin\UserController');
        Route::resource('product','\App\Http\Controllers\Admin\ProductController');
        Route::resource('productgallery','\App\Http\Controllers\Admin\ProductGalleryController');
        Route::resource('transaction','\App\Http\Controllers\Admin\TransactionController');
        Route::resource('report','\App\Http\Controllers\Admin\ReportController');
        Route::post('report/filter', [App\Http\Controllers\Admin\ReportController::class, 'filter'])->name('filter');

        // Product Variant Routes
        Route::get('product/{id}/createVariant', [App\Http\Controllers\Admin\ProductController::class, 'createVariant'])->name('createVariant');
        Route::post('product/storeVariant', [App\Http\Controllers\Admin\ProductController::class, 'storeVariant'])->name('storeVariant');
        Route::delete('product/{id}/storeVariant', [App\Http\Controllers\Admin\ProductController::class, 'destroyVariant'])->name('destroyVariant');
    });

Auth::routes();



<?php

use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagsController;

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

Route::get('/', function () {

    return  redirect('/login');        


});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

    Route::get('/dashboard', [ContentController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');;

Route::group(
    ['prefix' => 'admin', 'as' => 'admin'],
    function () {
        Route::middleware('auth')->group(function () {
            Route::get('posts/test', [ContentController::class, 'test']);
            Route::get('posts/admin', [ContentController::class, 'admin'])->name('posts');
            Route::get('tags/admin', [TagsController::class, 'admin'])->name('tags');
            Route::get('tags/{id}', [TagsController::class, 'show'])->name('tagview');
            Route::get('posts/postedContent', [ContentController::class, 'postedContent'])->name('posted');
            Route::get('posts/scheduled', [ContentController::class, 'scheduled'])->name('scheduled');
            Route::get('posts/customscheduled', [ContentController::class, 'customscheduled'])->name('customscheduled');
            Route::get('posts/recomended', [ContentController::class, 'recomendedSchedule'])->name('recomended');
            Route::post('posts/storeSchedule', [ContentController::class, 'storeSchedule'])->name('storeschedule');
            Route::post('posts/resetSchedule', [ContentController::class, 'resetSchedule'])->name('resetschedule');
            Route::get('posts/{id}/edit', [ContentController::class, 'edit'])->name('edit');
            Route::post('posts/{id}/store', [ContentController::class, 'store'])->name('store');
            Route::get('posts/{id}', [ContentController::class, 'show'])->name('show');


        });

    });

require __DIR__.'/auth.php';

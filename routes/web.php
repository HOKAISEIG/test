<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Models\Comment;

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



Route::group(['middleware' => 'prevent-back-history'],function(){
	Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');
    
    require __DIR__.'/auth.php';

    Route::get('/notes', function () {
        return NoteController::class;
    })->middleware(['auth'])->name('notes');

    Route::post('comments',[App\Http\Controllers\CommentController::class, 'store']);

    Route::get('edit-comment/{id}',[CommentController::class, 'edit' ]);
    Route::put('update-comment',[CommentController::class, 'update']);
    Route::resource('/notes', NoteController::class)->middleware(['auth']);

});
Route::post('delete-comment', [App\Http\Controllers\CommentController::class, 'destroy'])->name('deleteComment');

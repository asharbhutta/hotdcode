<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('validate.api')->group(function () {

Route::get('heart-beat', [ApiController::class, 'heartBeat']);
Route::get('get-data', [ApiController::class, 'getAllData']);
Route::get('get-tags', [ApiController::class, 'getTags']);
Route::get('get-post-tags', [ApiController::class, 'getPostTags']);
Route::get('get-post-tags-name', [ApiController::class, 'getPostTagsName']);
Route::get('update-metric/{id}/{metric}', [ApiController::class, 'updateContentMetric']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

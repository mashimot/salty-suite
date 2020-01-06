<?php

use Illuminate\Http\Request;

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
Route::apiResource('projects', 'API\ProjectController');
Route::apiResource('tools', 'API\ToolController');
Route::get('pages/{projectId}/project', 'API\PageController@index');

//Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
    Route::apiResource('pages', 'API\PageController');
    Route::put('pages/{projectId}/updatePosition', 'API\PageController@updatePosition');
    Route::apiResource('rows', 'API\RowController');
    Route::apiResource('columns', 'API\ColumnController');
    Route::apiResource('contents', 'API\ContentController');
    Route::apiResource('contents_choices', 'API\ContentChoiceController');
    //

    Route::post('contents_choices_items/store', 'API\ContentChoiceItemController@store');
    Route::apiResource('contents_choices_items', 'API\ContentChoiceItemController');

    Route::put('contents_choices/{id}/updatePosition', 'API\ContentChoiceController@updateContentChoicesPosition');
//});
Route::post('auth/register', 'API\AuthController@register');
Route::post('auth/login', 'API\AuthController@login');


/*Route::get('auth/login', 'Api\AuthController@login');
Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('auth/me', 'Api\AuthController@me');
});*/
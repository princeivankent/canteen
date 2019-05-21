<?php

Route::post('login', 'Auth\AuthController@login');

Route::group(['middleware' => ['api_token']], function () {
    // Guarded by api_token middleware
    Route::get('test_fetch', function () {
        return response()->json([
            'message' => 'Your good to go!'
        ]);
    });

    Route::get('meal_allowance/{employee_id}', 'MealController@get_meal_allowance');
});

<?php

use Illuminate\Support\Facades\Route;

Route::namespace( 'Auth' )->group( function () {
    Route::post( 'login/send-code' , 'LoginHandler@sendCode' );
    Route::post( 'login/verify-code' , 'LoginHandler@verifyCode' )->middleware( 'throttle:verify-code' );
    Route::post( 'login' , 'LoginHandler' )->middleware( 'throttle:login' );
    Route::post( 'register' , 'RegisterHandler' )->middleware( 'throttle:send-code' );
    Route::post( 'verify-register' , 'VerifyRegister' )->middleware( 'throttle:verify-code' );
    Route::post( 'logout' , 'LogoutHandler' )->middleware( 'auth:api' );
} );

Route::namespace( 'Password' )->group( function () {
    Route::post( 'reset-password' , 'ResetPasswordController' )->middleware( 'auth:api' );
    Route::post( 'forgot-password' , 'ResetPasswordController@forgot' );
    Route::post( 'verify-forgot-password' , 'ResetPasswordController@verify' );
    Route::post( 'change-password' , 'ChangePassword' )->middleware( 'auth:api' );
} );

Route::namespace( 'Blog' )->group( function () {
    Route::get( 'get-blogs' , 'IndexBlog@index' );
    Route::get( 'get-blogs/{blog}' , 'ShowBlog@show' );
    Route::get( 'get-similar-blogs/{blog}' , 'IndexBlog@similar' );
} );

Route::namespace( 'BlogCategory' )->group( function () {
    Route::get( 'get-blog-categories' , 'IndexBlogCategory@index' );
    Route::get( 'get-blog-categories/{blogCategory}' , 'ShowBlogCategory@show' );
} );


Route::namespace( 'Error' )->group( function () {
    Route::get( 'get-errors' , 'IndexError@index' );
    Route::get( 'get-errors/{error}' , 'ShowError@show' );
    Route::get( 'get-errors-by-name/{name}' , 'ShowError@showByName' );
} );

Route::namespace( 'ErrorItem' )->group( function () {
    Route::get( 'get-error-items' , 'IndexErrorItem@index' );
    Route::get( 'get-error-items/{errorItem}' , 'ShowErrorItem@show' );
} );

Route::namespace( 'Product' )->group( function () {
    Route::get( 'get-products' , 'IndexProduct@index' );
    Route::get( 'get-products/{product}' , 'ShowProduct@show' );
    Route::get( 'get-similar-products/{product}' , 'IndexProduct@similar' );
} );

Route::namespace( 'ProductCategory' )->group( function () {
    Route::get( 'get-product-categories' , 'IndexProductCategory@index' );
    Route::get( 'get-product-categories/{productCategory}' , 'ShowProductCategory@show' );
} );

//admin
Route::middleware( [ "auth:api" , "is_admin" ] )->group( function () {

    Route::namespace( 'User' )->group( function () {
        Route::handler( 'users' );
        Route::post( 'users/change-role/{user}' , 'ChangeRole' );
    } );

    Route::namespace( 'Request' )->group( function () {
        Route::handler( 'requests' );
        Route::post( 'requests-change-status/{request}' , 'ChangeStatus' );
        Route::get( 'requests-count-suspended' , 'CountSuspended' );
    } );

    Route::namespace( 'Sms' )->group( function () {
        Route::post( 'send-sms-user' , 'SendSms' );
    } );

    Route::namespace( 'Blog' )->group( function () {
        Route::handler( 'blogs' );
    } );

    Route::namespace( 'BlogCategory' )->group( function () {
        Route::handler( 'blog-categories' );
        Route::get( 'all-blog-categories' , 'IndexBlogCategory@All' );
    } );

    // Route::namespace( 'ErrorCategory' )->group( function () {
    //     Route::get( 'all-error-categories' , 'IndexErrorCategory@All' );
    // } );

    Route::namespace( 'ErrorCategory' )->group( function () {
        // Route::handler( 'error-categories' );
        Route::get( 'error-categories' , 'IndexErrorCategory' );
        Route::get( 'all-error-categories' , 'IndexErrorCategory@All' );
        Route::get( 'error-categories/{errorCategory}' , 'ShowErrorCategory' );
        Route::post('error-categories', 'storeErrorCategory');
        Route::delete( 'error-categories/{errorCategory}' , 'DestroyErrorCategory' );
    } );

    Route::namespace( 'ErrorBrand' )->group( function () {
        Route::get( 'error-brands' , 'IndexErrorBrand' );
        Route::get('error-brands/{errorBrand}','ShowErrorBrand');
    } );


    Route::namespace( 'Error' )->group( function () {
        Route::handler( 'errors' );
        Route::get( 'all-errors' , 'IndexError@All' );
        Route::post( 'errors' , 'StoreError' );
        Route::delete( 'errors/{error}' , 'DestroyError' );
    } );

    Route::namespace( 'ErrorItem' )->group( function () {
        Route::handler( 'error-items' );
        Route::post( 'error-items' , 'StoreErrorItem' );
        Route::delete( 'error-items/{ErrorItem}' , 'DestroyErrorItem' );
    } );

    Route::namespace( 'Product' )->group( function () {
        Route::handler( 'products' );

    } );

    Route::namespace( 'ProductCategory' )->group( function () {
        Route::handler( 'product-categories' );
        Route::get( 'all-product-categories' , 'IndexProductCategory@All' );
    } );

    Route::namespace( 'Media' )->group( function () {
        Route::post( 'media' , 'StoreMedia' );
        Route::post( 'file' , 'StoreMedia@store' );
        Route::delete( 'media/{media}' , 'DestroyMedia' );
    } );

    Route::namespace( 'ImportExcel' )->group( function () {
        Route::post('importExcel','StoreBrand@storeBrand');
    } );

} );

//user
Route::middleware( [ "auth:api" ] )->group( function () {

    Route::namespace( 'User' )->group( function () {
        Route::get( 'show-my-info' , 'ShowUser@ShowMyInfo' );
        Route::put( 'update-my-info' , 'UpdateUser@UpdateMyInfo' );
    } );

    Route::namespace( 'Request' )->group( function () {
        Route::get( 'index-deviceCategories' , 'IndexRequest@IndexDeviceCategory' );
        Route::get( 'show-my-requests/{request}' , 'ShowRequest' );
        Route::get( 'index-my-requests' , 'IndexRequest@IndexMyRequests' );
        Route::post( 'store-my-requests' , 'StoreRequest@StoreMyRequest' );
        Route::put( 'update-my-requests/{request}' , 'UpdateRequest@UpdateMyRequest' );
        Route::delete( 'delete-my-requests/{request}' , 'DestroyRequest' );
    } );

    Route::namespace( 'City' )->group( function () {
        Route::get( 'provinces' , 'IndexProvince' );
        Route::get( 'province/{province}' , 'ShowProvince' );
        Route::get( 'cities' , 'IndexCity' );
        Route::get( 'city/{city}' , 'ShowCity' );
    } );

} );



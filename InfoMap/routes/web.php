<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUser;
/**
 * Models
 */
use App\User;
use App\Location;
use App\Comment;
use App\Image;
/**
 * Basic page
 */
Route::get('/', function () {
    $locations = new Location;
    $comments = new Comment;
    $images = new Image;
    return view('layouts.userLayouts.guestPage',compact('locations','comments','images'));
});


$goup = [
    'namespace' => 'LocationMap',
    'middleware' => ['auth']
];
Route::group($goup,function(){
    /**
     * Admin route
     */
    $methods_admin = ['index','edit','show','update','create','store','destroy'];
    Route::resource('admin/location','AdminController')
    ->only($methods_admin)
    ->names('admin');
    Route::post('admin/upload','AdminController@uploads');
    /**
     * Route vue
     * */ 
    // Route::get('/admin/map','AdminController@index');
    // Route::get('/admin/location','AdminController@show');
    // Route::get('/admin/location/{id}', 'AdminController@show');
    // Route::get('/admin/location','AdminController@index');
    /**
     * User route 
     * */ 
    $methods_user = ['index','update','store','destroy'];
    Route::resource('user','UserController')
    ->only($methods_user)
    ->names('user')
    ->middleware('userCheck');
    Route::post('/user/upload','UserController@uploads')->name('user.upload');
});



/**
 * Ajax function
 */
Route::get('/location/{id}',function($id){
    return Location::where('id',$id)->first();
});
Route::get('/images/{location_id}',function($location_id){
    return Image::where('location_id',$location_id)->select('image_url')->get();
});
Route::get('/comments/{location_id}',function($location_id){
    return Comment::where('location_id',$location_id)->orderBy('updated_at','desc')->get();
});
Route::get('/user/{user_id}',function($user_id){
    return Comment::where('user_id',$user_id)->user;
});

// Authenticate
Auth::routes();


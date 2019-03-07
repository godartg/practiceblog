<?php

Route::get('/', 'PagesController@home')->name('pages.home');
Route::get('nosotros', 'PagesController@about')->name('pages.about');
Route::get('archivo', 'PagesController@archive')->name('pages.archive');
Route::get('contacto', 'PagesController@contact')->name('pages.contact');

Route::get('blog/{post}','PostsController@show')->name('posts.show');
Route::get('categorias/{category}','CategoriesController@show')->name('categories.show');
Route::get('tags/{tag}','TagsController@show')->name('tags.show');

Route::get('posts', function(){
	return App\Post::all();
});


Route::group([
	'prefix' => 'admin', 
	'namespace' => 'Admin',
	'middleware' => 'auth'], 
	function (){
	Route::get('/','AdminController@index')->name('dashboard');
	Route::post('posts/{post}/photos','GoogleDriveController@store')->name('admin.posts.photos.store');
	Route::delete('photos/{photo}','GoogleDriveController@destroy')->name('admin.photos.destroy');
	Route::resource('posts','PostsController',['except' => 'show', 'as' => 'admin']);
	Route::resource('users','UsersController',['as' => 'admin']);
	Route::middleware('role:Admin')
		->put('users/{user}/roles','UsersRolesController@update')
		->name('admin.users.roles.update');
	Route::middleware('role:Admin')
		->put('users/{user}/permissions','UsersPermissionsController@update')
		->name('admin.users.permissions.update');
});

Route::middleware('auth')->group(function(){
    Route::get('/api', 'GoogleDriveController@getFolders')->name('google.folders');
    Route::get('/api/upload', 'GoogleDriveController@uploadFiles');
});
//Rutas de autenticación con redes sociales
Route::get('login/google', 'SocialAuthController@redirectToGoogleProvider')->name('login.google');
Route::get('login/google/callback', 'SocialAuthController@handleProviderGoogleCallback');
// Route::get('/home', 'HomeController@index')->name('home');


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


// Route::get('email', function(){
// 	return new App\Mail\LoginCredentials(App\User::first(), '123456');
// });

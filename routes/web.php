<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'RestaurantController@getPagesAction');
$app->get('/main.{page}', 'RestaurantController@indexAction');

$app->get('/searchRestaurantPage&lat={lat}&lng={lng}&search={search}&page={page}&miles={miles}',
        'RestaurantController@searchPageAction');
$app->get('/searchRestaurant', 'RestaurantController@searchAction');

$app->get('/loginPage', function() {
    return view('login');
});
$app->post('/signIn','UserController@loginAction');
$app->get('/logout','UserController@logoutAction');

$app->get('/signUpPage', function() {
    return view('signup');
});
$app->post('/signUp','UserController@createUserAction');

$app->get('/restaurantSignPage.{code}', 'adminController@verifyCodeAction');
$app->post('/restaurantSignUp', 'RestaurantController@createRestaurantAction');
$app->get('/restaurant.{id}', 'RestaurantController@getRestaurantAction');

$app->get('/profileUserPage','UserController@getUserAction');
$app->post('/updateUser', 'UserController@updateUserAction');

$app->get('/profilePasswordPage', function() {
    return view('profile_password');
});
$app->post('/updatePassword', 'UserController@updatePasswordAction');

$app->get('/profileRestaurantPage.{id}','RestaurantController@editRestaurantAction');
$app->post('/updateRestaurant','RestaurantController@updateRestaurantAction');

$app->get('/profileRestaurantImgPage.{id}','RestaurantController@editRestaurantImgAction');
$app->post('/img-upload.{id}','RestaurantController@uploadRestaurantImgAction');
$app->post('/img-delete.{id}','RestaurantController@deleteRestaurantImgAction');
$app->post('/img-default.{id}','RestaurantController@defaultRestaurantImgAction');

$app->get('/profileNewRestaurantPage', function() {
    return view('profile_new_restaurant');
});

$app->get('/uploadReceiptPage.{id}', function($id) {
    return view('upload_receipt',['id'=>$id]);
});

$app->post('/sendEmail', 'AdminController@sendEmailAction');

$app->post('/addRating','RatingController@addRatingAction');
$app->get('/getRestaurantRatings','RatingController@getRestaurantRatingsAction');


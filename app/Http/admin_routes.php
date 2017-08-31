<?php


Route::group([ 'namespace' => 'Admin'], function () {
    Route::get('ueditor/config', 'UeditorController@getConfig');
});
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('investments','InvestmentsController@index');

    Route::get('/', 'DashboardController@index');

    Route::resource('/shoot_orders', 'ShootOrdersController');
    Route::resource('/videos', 'VideosController');

    Route::group(['prefix' => '/users'], function () {
        Route::get('/search', 'UsersController@search');
    });
    Route::resource('users', 'UsersController');

    Route::get('/roles/delete', 'RolesController@delete');
    Route::resource('/roles', 'RolesController');
    Route::resource('/pictures', 'PicturesController');

    Route::get('/movies/{movie}/lock-name','MoviesController@lock');
    Route::get('/movies/{movie}/unlock-name','MoviesController@unlock');
    Route::get('/movies/{movie_id}/users', 'MoviesController@users');
    Route::resource('/movies', 'MoviesController');

    Route::get('education-schools/easy-education', 'EducationSchoolsController@easyEducation');

    Route::resource('/groups', 'GroupsController');

    Route::resource('/group_users', 'GroupUsersController');

    Route::resource('/notices', 'NoticesController');

    Route::resource('/advertisements', 'AdvertisementsController');

    Route::resource('/comments', 'CommentsController');

    Route::resource('/bulletins', 'BulletinsController');

    Route::resource('/banners', 'BannersController');
    Route::get('/banners/{bannerid}/show', 'BannersController@showBanner');
    Route::get('/banners/{bannerid}/notshow', 'BannersController@notshowBanner');

    Route::resource('/blogs', 'BlogsController');

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/create/autoload', 'CompanyController@autoload');

        Route::group(['prefix' => '{id}'], function () {
            Route::get('/edit-cooperation-config', 'CompanyController@editCooperationConfig');
            Route::put('/allow-cooperation', 'CompanyController@toggleAllowCooperations');
        });
    });
    Route::resource('/companies', 'CompanyController');

    Route::group(['prefix' => 'scripts'], function () {
        Route::get('/create/autoload', 'ScriptController@autoload');

        Route::group(['prefix' => '{id}'], function () {
            Route::get('/edit-cooperation-config', 'ScriptController@editCooperationConfig');
            Route::put('/allow-cooperation', 'ScriptController@toggleAllowCooperations');
        });
    });
    Route::resource('/scripts', 'ScriptController');
    Route::resource('/recruits', 'RecruitsController');


    Route::group(['prefix' => 'basement'], function () {
        Route::get('/create/autoload', 'BasementsController@autoload');

        Route::group(['prefix' => '{id}'], function () {
            Route::get('/edit-cooperation-config', 'BasementsController@editCooperationConfig');
            Route::put('/allow-cooperation', 'BasementsController@toggleAllowCooperations');
        });
    });
    Route::get('/basements/{type}', 'BasementsController@index');
    Route::get('/basements/{type}/create', 'BasementsController@create');
    Route::post('/basements/{type}', 'BasementsController@store');
    Route::get('/basements/{type}/{basementId}', 'BasementsController@edit');
    Route::delete('basements/{type}/{basementId}', 'BasementsController@destroy');
    Route::patch('/basements/{type}/{basementId}', 'BasementsController@update');
    Route::post('/basements/upload/a/a', 'BasementsController@upload');

    Route::get('/unions/{type}', 'UnionsController@index');
    Route::get('/unions/{type}/create', 'UnionsController@create');
    Route::post('/unions/{type}', 'UnionsController@store');
    Route::delete('/unions/{type}/{userId}', 'UnionsController@destroy');
    /* Route::get('/basements/create/autoload','BasementsController@autoload');*/

    Route::resource('/profiles', 'ProfilesController');

    Route::resource('/albums', 'AlbumsController');

    Route::resource('/messages', 'MessagesController');

    Route::post('/messages/countNums', 'MessagesController@countNums');

    Route::resource('/sms_records', 'SmsRecordsController');

    Route::resource('/feedbacks', 'FeedbacksController');

    Route::resource('/reports', 'ReportsController');

    Route::resource('/permissions', 'PermissionsController');

    Route::resource('/profilerecords', 'ProfileRecordsController');

    Route::resource('/profiles/{profiles_sorts}/sorts', 'ProfilesController@sorts');

    Route::resource('/products', 'ProductsController');

    Route::get('/products/{productId}/prices', 'ProductsController@prices');

    Route::get('/products/{brandsId}/brands', 'ProductsController@brands');

    Route::resource('/product-sizes', 'ProductSizesController');

    Route::resource('/product-prices', 'ProductPricesController');

    Route::resource('/product-brands', 'ProductBrandsController');

    Route::resource('/orders', 'OrdersController');

    Route::resource('/social-securities', 'SocialSecuritiesController');

    //获取订单请求 的路径
    Route::get('/get-purchase-request-root-url', 'JavascriptController@getPurchaseRequestRootUrl');

    Route::get('/blogs/{blog}/clear-cache', 'BlogsController@clearCache');
    //修改艺人形象照
    Route::resource('/profiles/editpic', 'ImageForAlbumController');

    Route::get('/black-lists/{id}/delete', 'BlackListsController@destroy');
    Route::resource('/black-lists', 'BlackListsController');

});


<?php

Route::group(['namespace' => 'Api', 'prefix' => 'api'], function () {


    /**
     * 通告单相关
     */
    Route::group(['prefix'=>'notices'],function(){

        //每日通告单列表
        Route::get('/daily','NoticesController@daily');

        //预备通告单列表
        Route::get('/prepare','NoticesController@prepare');

        //通告单详情
        Route::get('/{notice_id}', 'NoticesController@show');


        //发送通告单某一个文件
        Route::post('/files/{notice_file_id}/send','NoticesController@sendNoticeFile');

        //撤销通告单文件
        Route::post('/files/{notice_file_id}/undo','NoticesController@undo');

        //查看通告单的某一个文件接收详情
        Route::get('/files/{notice_file_id}/receivers','NoticesController@receivers');

        //预备通告单选择接收人
        Route::get('/prepare/files/{notice_file_id}/choose','NoticesController@choose');

    });

    Route::post('/pays/callback', 'PaysController@callback');

    Route::post('/pays/charge', 'PaysController@charge');

    Route::get('weather', 'WeatherController@index');
    //登陆注册
    Route::get('account/verify_code', 'AccountsController@verify_code');

    Route::post('account/login', 'AccountsController@login');

    Route::post('account/update', 'AccountsController@update');

    Route::get('pictures', 'PicturesController@index');

    Route::post('pictures/callback', 'PicturesController@callback');

    //用户相关
    Route::group(['prefix'=>'users/{user_id}'],function(){

        //发布的招聘信息
        Route::get('/recruits', 'UsersController@recruits');

        //更新备忘录
        Route::put('/blogs/{id}', 'UsersController@blog_update');

        //删除备忘录
        Route::delete('/blogs/{id}', 'UsersController@blog_delete');

        //更新用户选择的天气的地址
        Route::put('/weather/location','WeatherController@updateLocation');

        //获取用户选择的天气的地址
        Route::get('/weather/location','WeatherController@getLocation');

        //获取用户的所有备忘录
        Route::get('/blogs', 'UsersController@blogs');

        //用户的所有消息通知
        //现在包括了剧组通知,系统通知,好友消息等
        Route::get('/messages', 'UsersController@messages');
        //用户的喜欢的
        Route::get('/favorites', 'UsersController@favorites');

        //更新个人资料
        Route::post('/profiles/update', 'UsersController@profile_update');

        //该用户收到的所有好友申请
        Route::get('/friend_applications','FriendsController@applications');

        //向用户发出好友申请
        Route::post('/friend_applications','FriendsController@applyUserBeFriend');

        //同意好友申请
        Route::put('/friend_applications/{applicationId}','FriendsController@approveApplication');

        //删除好友
        Route::delete('/friends/{friendId}','FriendsController@deleteFriend');

        //用户的所有好友
        Route::get('/friends','FriendsController@friends');

        //用户所在的所有剧组所有部门
        Route::get('/joined_movie_groups','HxGroupController@joinedMovieGroups');

        //获取用户创建的环信群组信息
        Route::get('/joined_app_create_chat_groups/','HxGroupController@joinedAppCreateGroups');

        //发送邀请,邀请用户注册app或者打开好友聊天或者发起好友申请
        Route::post('/invites','UsersController@sendInvitation');

        //获取用户信息
        Route::get('/info','UsersController@getUserInfo');

        //获取群组详情
        Route::get('/chat_groups/{hxGroupId}','HxGroupController@show');

        //群组添加用户
        Route::post('/chat_groups/{hxGroupId}/users/{userId}','HxGroupController@addMember');

        //群组删除用户(只有群主可以操作)
        Route::delete('/chat_groups/{hxGroupId}/users/{userId}','HxGroupController@deleteMember');

        //解散群组
        Route::delete('/chat_groups/{hxGroupId}','HxGroupController@dismissGroup');

        //群成员退出群组(群主必须先移交权限)
        Route::post('/chat_groups/{hxGroupId}/exit','HxGroupController@exitGroup');

        //转让群主
        Route::put('/chat_groups/{hxGroupId}/transfor_owner/{newUserId}','HxGroupController@transforOwner');

        //更新群组公告
        Route::put('/chat_groups/{hxGroupId}','HxGroupController@updateHxGroupInfo');

        //环信加入黑名单
        Route::post('/chat_groups/{hxGroupId}/blacklists/users/{userId}','HxGroupController@groupBlockUser');

        //环信用户剔除黑名单
        Route::delete('/chat_groups/{hxGroupId}/blacklists/users/{userId}','HxGroupController@groupUnBlockUser');

        //获取环信群聊黑名单
        Route::get('/chat_groups/{hxGroupId}/blacklists','HxGroupController@groupBlackLists');

        //用户自己创建的群聊
        Route::post('/app_create_group','HxGroupController@appCreateHxGroup');

        //把im用户加入某人黑名单
        Route::post('/blacklists/users/{userid}','UsersController@userBlockUser');

        //把im用户移除某人黑名单
        Route::delete('/blacklists/users/{userId}','UsersController@userUnBlockUser');

        //查看用户的im黑名单
        Route::get('/blacklists','UsersController@userBlackLists');

        //获取用户的协助编辑列表
        Route::get('/can_edit_profiles/','UsersController@canEditProfiles');

        //获取用户的当前的位置
        Route::get('/location','LocationsController@getUserLocation');

        //更新用户的当前位置(经纬度,30s前端调用一次)
        Route::post('/location','LocationsController@storeUserLocation');

    });

    Route::resource('users', 'UsersController', ['only' => ['show']]);

    Route::resource('/banners', 'BannersController');

    Route::resource('/shoot_orders', 'ShootOrdersController');

    //业内动态
    Route::get('/blogs/types', 'BlogsController@types');

    Route::resource('/blogs', 'BlogsController');

    Route::resource('/recruits', 'RecruitsController');

    Route::resource('/messages', 'MessagesController');

    Route::post('/reports', 'ReportsController@store');

    Route::post('/favorites/delete', 'FavoritesController@destroy');

    Route::post('/favorites', 'FavoritesController@store');

    Route::post('/feedbacks', 'FeedbacksController@store');

    Route::post('/likes/delete', 'LikesController@destroy');

    Route::post('/likes', 'LikesController@store');

    Route::get('/profiles/types', 'ProfilesController@types');

    Route::resource('/profiles', 'ProfilesController');

    Route::resource('/groups', 'GroupsController');

    //备忘录
    Route::resource('/todos', 'TodosController');

    //获取专业视频
    Route::get('/video/professional','GroundController@getProfessionalVideoUrl');

    //广场动态
    Route::resource('/ground', 'GroundController');

    Route::resource('/menus', 'MenusController');

    Route::resource('/movies', 'MoviesController');

    Route::get('/appUpdate','VersionsController@index');

    //版本控制
    Route::resource('/versions', 'VersionsController');

    //web im
    Route::group(['prefix'=>'im'], function(){

        //获取用户信息
        Route::get('/getUsersInfo','ImController@getUsersInfo');

        //获取群组信息
        Route::get('/getGroupsInfo','ImController@getGroupsInfo');

    });

});

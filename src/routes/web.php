<?php
    
    Route::group(['namespace'=>'codexivesolutions\messenger\Http\Controllers','middleware' => ['web','auth']],function(){
        Route::post('/get_message','MessageController@get_message');
        Route::post('/receiver_name','MessageController@receiver_name');
        Route::resource('/messages','MessageController');
        });

?>
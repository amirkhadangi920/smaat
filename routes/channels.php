<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('newTask', function(){
//     dd('fuck');

//     echo 'event was brodcasted' . PHP_EOL;
//     return true;
// });


Broadcast::channel('brand', function ($user) {

    return $user->can('read-brands');
});



Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

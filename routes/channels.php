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

use App\PlayerSession;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Quiz.{quizSessionId}', function ($user = null, $quizSessionId) {
    return (int) PlayerSession::id() === (int) $quizSessionId;
});

Broadcast::channel('User.Quiz.{quizSessionId}', function ($user, $quizSessionId) {
    return !! $user;
});

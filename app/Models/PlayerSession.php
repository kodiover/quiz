<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class PlayerSession
{
    // Validates id in order to assign it to the key
    public static function id($id = null)
    {
        if ($id === null) {
            return Session::get('active_quiz_session');
        }

        return Session::put('active_quiz_session', $id);
    }

    // Validates nickname in order to assign it to the key
    public static function nickname($nickname = null)
    {
        if ($nickname === null) {
            return Session::get('active_quiz_session_nickname');
        }

        return Session::put('active_quiz_session_nickname', $nickname);
    }

    // Allows for the class to clear the session specified
    public static function clear()
    {
        Session::forget(['active_quiz_session_nickname', 'active_quiz_session']);
    }
}

<?php

use App\Mail\NewUserNotification;
use App\QuizSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::livewire('/', 'index')->name('index');
Route::livewire('/quiz/{quizSession}', 'quiz')->name('quiz.enter');
Route::livewire('/quiz/{quizSession}/play', 'play-quiz')->name('quiz.play');

/**
 * Authentication routes
 */
Route::group(['middleware' => ['guest']], function () {
    Route::livewire('/login', 'auth.login')->name('login');
    Route::livewire('/register', 'auth.register')->name('register');
    Route::livewire('/password/reset', 'auth.passwords.email')->name('password.request');
    Route::livewire('/password/reset/{token}', 'auth.passwords.reset')->name('password.reset');
    Route::post('/password/reset', 'Auth\ForgotPasswordController@reset')->name('password.update');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['throttle:6,1']], function () {
        Route::livewire('/email/verify', 'auth.verify')->name('verification.notice');
        Route::group(['middleware' => ['signed']], function () {
            Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
        });
    });
});

Route::group(['middleware' => ['auth', 'verified']], function(){
        Route::livewire('/home', 'user.home')->name('home');
        Route::livewire('/manage/quizzes/{quiz}', 'user.manage-quiz')->name('user.quizzes.manage');
        Route::livewire('/quiz/{quizSession}', 'user.quiz')->name('user.quiz.start');
        Route::livewire('/quiz/{quizSession}/play', 'user.play-quiz')->name('user.quiz.play');
        Route::livewire('/quiz/{quizSession}/leaderboard', 'user.quiz-leaderboard')->name('user.quiz.leaderboard');
        Route::livewire('/logout', 'auth.logout')->name('logout');

        Route::post('/quiz/{quizSession}/next', function (QuizSession $quizSession) {
            $question = $quizSession->nextQuestion($delayInSeconds = 1);

            if ($question === null) {
                return redirect()->route('user.quiz.leaderboard', $quizSession);
            }

            return redirect()->route('user.quiz.play', $quizSession);
        })->name('user.quiz.next');

    });

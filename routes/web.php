<?php

use App\PlayerSession;
use App\QuizSession;
use Illuminate\Support\Facades\Route;

Route::layout('layouts.app')->section('body')->group(function () {
    Route::livewire('/', 'index')->name('index');
    Route::livewire('/quiz/{quizSession}', 'quiz')->name('quiz.enter');
    Route::livewire('/quiz/{quizSession}/play', 'play-quiz')->name('quiz.play');
});

Route::layout('layouts.app')
    ->section('body')
    ->prefix('admin')
    ->middleware('auth.basic')
    ->group(function () {
        Route::livewire('/', 'user.home')->name('user.home');
        Route::livewire('/manage/quizzes/{quiz}', 'user.manage-quiz')->name('user.quizzes.manage');
        Route::livewire('/quiz/{quizSession}', 'user.quiz')->name('user.quiz.start');
        Route::livewire('/quiz/{quizSession}/play', 'user.play-quiz')->name('user.quiz.play');
        Route::livewire('/quiz/{quizSession}/leaderboard', 'user.quiz-leaderboard')->name('user.quiz.leaderboard');

        Route::post('/quiz/{quizSession}/next', function (QuizSession $quizSession) {
            $question = $quizSession->nextQuestion($delayInSeconds = 1);

            if ($question === null) {
                return redirect()->route('user.quiz.leaderboard', $quizSession);
            }

            return redirect()->route('user.quiz.play', $quizSession);
        })->name('user.quiz.next');
    });

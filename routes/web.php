<?php

use App\Models\QuizSession;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function() {
    Route::get('/', \App\Http\Livewire\Index::class)->name('home');
    
    // Route::post('/quiz/{quizSession}', function (Quiz $quiz) {
    //     return redirect()->route('user.quiz', $quiz);
    // })->name('quiz');

    Route::get('/quiz/{quizSession}', \App\Http\Livewire\Quiz::class)->name('quiz.start');
    Route::get('/quiz/{quizSession}/play', \App\Http\Livewire\PlayQuiz::class)->name('quiz.play');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/home', \App\Http\Livewire\User\Home::class)->name('user.home');
    Route::get('/manage/quizzes/{quiz}', \App\Http\Livewire\User\ManageQuiz::class);
    Route::get('/quiz/{quizSession}', \App\Http\Livewire\User\Quiz::class)->name('user.quiz');
    Route::get('/quiz/{quizSession}/play', \App\Http\Livewire\User\PlayQuiz::class)->name('user.quiz.play');
    Route::get('/quiz/{quizSession}/leaderboard', \App\Http\Livewire\User\QuizLeaderboard::class)->name('user.quiz.leaderboard');

        Route::post('/quiz/{quizSession}/next', function (QuizSession $quizSession) {
            $question = $quizSession->nextQuestion($delayInSeconds = 1);

            if ($question === null) {
                return redirect()->route('user.quiz.leaderboard', $quizSession);
            }

            return redirect()->route('user.quiz.play', $quizSession);
        })->name('user.quiz.next');
});





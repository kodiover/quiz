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

// Route::get('/', function(){
//     return view('welcome');
// });

// Yes that correct but the login should show 
// mean? because it says logout  
//okay


Route::group(['middleware' => ['guest']], function() {
    Route::get('/', \App\Http\Livewire\Index::class);// this route should be run right? Yes Okay Okay?
    Route::get('/quiz/{quizSession}', \App\Http\Livewire\Quiz::class);
    Route::get('/quiz/{quizSession}/play', \App\Http\Livewire\PlayQuiz::class);
    // Route::get('/', \App\Http\Livewire\User\Home::class);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/home', \App\Http\Livewire\User\Home::class);
    Route::get('/manage/quizzes/{quiz}', \App\Http\Livewire\User\ManageQuiz::class);
    Route::get('/quiz/{quizSession}', \App\Http\Livewire\User\Quiz::class);
    Route::get('/quiz/{quizSession}/play', \App\Http\Livewire\User\PlayQuiz::class);
    Route::get('/quiz/{quizSession}/leaderboard', \App\Http\Livewire\User\QuizLeaderboard::class);


        Route::post('/quiz/{quizSession}/next', function (QuizSession $quizSession) {
            $question = $quizSession->nextQuestion($delayInSeconds = 1);

            if ($question === null) {
                return redirect()->route('user.quiz.leaderboard', $quizSession);
            }

            return redirect()->route('user.quiz.play', $quizSession);
        })->name('user.quiz.next');
});
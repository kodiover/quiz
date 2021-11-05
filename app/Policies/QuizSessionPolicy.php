<?php

namespace App\Policies;

use App\Models\PlayerSession;
use App\Models\QuizSession;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizSessionPolicy
{
    use HandlesAuthorization;

    public function view($user = null, QuizSession $quizSession)
    {
        return (int) $quizSession->id === (int) PlayerSession::id()
            && $quizSession->players->pluck('nickname')
                ->contains(PlayerSession::nickname());
    }

    public function redirect($path, QuizSession $quizSession)
    {
        if ($quizSession->isActive()) {
            return redirect(route($path));
        }
    }

    public function play($user = null, QuizSession $quizSession)
    {
        return $this->view($user, $quizSession)
            && $quizSession->isActive();
    }


}

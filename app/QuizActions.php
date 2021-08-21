<?php

namespace App;

trait QuizActions {

    /**
     * Gets boolean value once function is called
     * 
     * @return bool
     */
    public function quizState(){
        return true;
    }

    /**
     * Checks if quiz session has ended
     * 
     */
    public function checkEndQuiz($int)
    {
        if ($int === 1){
            $this->quizState();
        }
        return;
    }
}
<?php

namespace App;

trait QuizActions {

    public $reload = false;

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

    /**
     * Checks if quiz has started
     * 
     */
    public function checkQuizStart($int)
    {
        if ($int === 1){
            $this->reload = true;
        } else {
            $this->reload = false;
        }
    }
}
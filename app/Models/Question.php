<?php

namespace App\Models;

use App\Exceptions\UnknownOptionKey;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Variable to convert the options column to an array
    protected $casts = [ 
        'options' => 'array'
    ];

    // Variable to define attributes that aren't mass assignable
    protected $guarded = []; 

    // Function to throw an error if the correct key is not linking to an option
    public static function boot() 
    {
        parent::boot();

        static::saving(static function($question) {
            if(! in_array($question->correct_key, array_keys($question->options))) {
                throw new UnknownOptionKey('options doesn\'t have the correct key');
            }
        });
    }
    
    // Function that defines a child for the Quiz class
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Function that links Question with QuestionResponse class
    public function responses()
    {
        return $this->hasMany(QuestionResponse::class, 'question_id');
    }

    // Function which returns true if the variable passed is equal to the correct key
    public function isCorrect($key)
    {
        return $this->correct_key === $key;
    }
}

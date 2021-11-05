<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_responses', function (Blueprint $table) {
            $table->bigIncrements('id'); // Default Id incrementer
            $table->unsignedBigInteger('player_id'); // Set to positive only
            $table->unsignedBigInteger('question_id'); // Set to positive only
            $table->string('response', 5); // Method sets min value of 5
            $table->unsignedInteger('score')->nullable(); // Set to positive only and can be null
            $table->timestamps();
            
            $table->foreign('player_id')->references('id')->on('quiz_players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_responses');
    }
}

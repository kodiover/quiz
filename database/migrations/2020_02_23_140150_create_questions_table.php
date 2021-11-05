<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id'); // Default Id incrementer
            $table->text('text', 400); // The text key used to define the Qs text
            $table->unsignedBigInteger('quiz_id')->index(); // Method used to add indicies to the column
            $table->unsignedTinyInteger('time_limit'); // Set to positive only
            $table->json('options'); // Method for adding extra data to a column
            $table->string('correct_key', 5); // Method sets min value of 5
            $table->timestamps();
            
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivateToQuizzes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function(Blueprint $table){
            $table->tinyInteger('isPrivate')->nullable()->default(0);
            $table->string('password')->nullable();
         });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quizzes', function(Blueprint $table){
            $table->dropColumn('isPrivate');
            $table->dropColumn('password');
         });
    }
}

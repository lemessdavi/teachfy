<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Card;
use App\Models\Option;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('card_id')->references('id')->on('cards');
            $table->foreignId('option_id')->nullable()->references('id')->on('options');

            $table->text('difficulty')->nullable();

            //add check constraint [0,1] binary and
            $table->decimal('grade', $precision = 5, $scale = 2)->nullable(); //maybe change de the name of this column

            $table->text('feedback')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};

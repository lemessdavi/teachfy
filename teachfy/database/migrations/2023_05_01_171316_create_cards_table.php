<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Deck;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('deck_id')->unsigned();
            $table->smallInteger('deck_type');
            $table->foreign(['deck_id', 'deck_type'])->references(['id', 'type'])->on('decks');

            $table->smallInteger('type'); //add check constraint [0,1] 
            $table->text('question');
            $table->text('answer')->nullable();
            $table->decimal('points', $precision = 5, $scale = 2)->nullable(); //this column name needs to be changed

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};

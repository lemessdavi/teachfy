<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Folder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Folder::class);
            $table->string('name');
            $table->smallInteger('public')->default(0); //add check constraint [0,1] binary
            $table->smallInteger('clonable')->default(0); //add check constraint [0,1] binary
            $table->smallInteger('feedback')->default(0); //add check constraint [0,1] binary
            $table->smallInteger('type'); //add check constraint [0,1]

            $table->unique(['id', 'type']);

            //$table->smallInteger('libernota')->default(0); //add check constraint [0,1]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};

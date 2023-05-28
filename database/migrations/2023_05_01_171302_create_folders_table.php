<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Folder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Folder::class)->nullable(); //father
            $table->string('name');
            $table->smallInteger('public')->default(0); //add check constraint [0,1] binary | added in folderRequest rules 
            $table->smallInteger('clonable')->default(0); //add check constraint [0,1] binary | added in folderRequest rules 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};

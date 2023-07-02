<?php

use App\Structural\Enums\CardType;
use App\Structural\Enums\DeckType;
use App\Structural\Enums\ParticipantPermission;
use App\Structural\Enums\YesNo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCheckConstraints extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE decks ADD CONSTRAINT chk_type CHECK (type = ANY (ARRAY[' . implode(', ', array_column(DeckType::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE decks ADD CONSTRAINT chk_public CHECK (public = ANY (ARRAY[' . implode(', ', array_column(YesNo::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE decks ADD CONSTRAINT chk_clonable CHECK (clonable = ANY (ARRAY[' . implode(', ', array_column(YesNo::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE decks ADD CONSTRAINT chk_feedback CHECK (feedback = ANY (ARRAY[' . implode(', ', array_column(YesNo::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE cards ADD CONSTRAINT chk_type CHECK (type = ANY (ARRAY[' . implode(', ', array_column(CardType::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE participants ADD CONSTRAINT chk_permission CHECK (permission = ANY (ARRAY[' . implode(', ', array_column(ParticipantPermission::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE folders ADD CONSTRAINT chk_public CHECK (public = ANY (ARRAY[' . implode(', ', array_column(YesNo::cases(), 'value')) . ']));');
        DB::statement('ALTER TABLE folders ADD CONSTRAINT chk_clonable CHECK (clonable = ANY (ARRAY[' . implode(', ', array_column(YesNo::cases(), 'value')) . ']));');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};

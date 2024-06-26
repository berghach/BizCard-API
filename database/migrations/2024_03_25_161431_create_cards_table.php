<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('card_owner');
            $table->string('occupation');
            $table->string('adresse');
            $table->text('bio');
            $table->string('phone_number');
            $table->string('e_mail');
            $table->foreignId('user_id')->constrained('users', 'id', 'card_user_id')->cascadeOnDelete();
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

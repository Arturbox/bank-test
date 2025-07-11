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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users')->OnUpdate('cascade');
            $table->foreignId('to_user_id')->constrained('users')->OnUpdate('cascade');
            $table->foreignId('from_account_id')->constrained('accounts')->OnUpdate('cascade');
            $table->foreignId('to_account_id')->constrained('accounts')->OnUpdate('cascade');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};

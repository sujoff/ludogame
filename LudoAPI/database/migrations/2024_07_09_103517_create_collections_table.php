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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ["board","dice","emote","token"]);
            $table->string('code')->unique()->nullable();
            $table->string('image')->nullable();
            $table->decimal('cost')->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency_type')->nullable();
            $table->enum('status', ["active","inactive"])->default('active');
            $table->enum('category', ['inventory', 'currency'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};

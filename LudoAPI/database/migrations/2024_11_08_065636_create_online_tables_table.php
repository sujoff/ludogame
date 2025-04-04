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
        Schema::create('online_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('entry_cost')->nullable();
            $table->json('prizes')->nullable();
            $table->json('xps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_tables');
    }
};

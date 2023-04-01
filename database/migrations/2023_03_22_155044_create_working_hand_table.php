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
        Schema::create('working_hand', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->double("price",15, 8);
            $table->timestamps();
            $table->foreignId("proid")->constrained('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_hand');
    }
};

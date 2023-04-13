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
        Schema::create('proudct_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId("rawid")->constrained("rawmaterials")->onDelete('cascade');
            $table->foreignId("proid")->constrained("products")->onDelete('cascade');
            $table->double("quan",15, 8);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proudct_material');
    }
};

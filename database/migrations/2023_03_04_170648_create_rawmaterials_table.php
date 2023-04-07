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
        Schema::create('rawmaterials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('material_name');
            $table->boolean('hisba_type');
            $table->double('quantity',15, 8);
            $table->double('price',15, 8);
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawmaterials');
    }
};

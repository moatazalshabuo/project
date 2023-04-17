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
        Schema::create('system_mangs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("logo_name");
            $table->integer("phone");
            $table->string('email');
            $table->string('logo_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_mangs');
    }
};
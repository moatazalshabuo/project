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
        //
        Schema::table("clients",function(Blueprint $table){
            $table->bigInteger("phone")->nullable()->change();
            $table->string('address',50)->nullable();
        });
        Schema::table("customers",function(Blueprint $table){
            $table->bigInteger("phone")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

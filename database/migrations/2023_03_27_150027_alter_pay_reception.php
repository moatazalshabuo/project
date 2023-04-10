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
        Schema::create('exchange_receipt', function (Blueprint $table) {
            $table->id();
            $table->integer("bill_id")->nullable();
            $table->string('desc')->nullable();
            $table->double("price",15, 2);
            $table->integer("type");
            $table->foreignId("created_by")->constrained("users");
            $table->timestamps();
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

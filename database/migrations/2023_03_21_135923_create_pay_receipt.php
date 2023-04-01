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
        Schema::create('pay_receipt', function (Blueprint $table) {
            $table->id();
            $table->foreignId("bill_id")->constrained("salesbills");
            $table->double("price",15, 8);
            $table->foreignId("created_by")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_receipt');
    }
};

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
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("prodid")->constrained("products");
            $table->foreignId('sales_id')->constrained("salesbills")->onDelete('cascade');
            $table->string("descripe",191)->default("");
            $table->double("qoun",15, 8);
            $table->double("descont",15, 8);
            $table->double("total",15, 2)->nullable();
            $table->foreignId("user_id")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
};

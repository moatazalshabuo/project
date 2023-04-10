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
        Schema::create('purchases_items', function (Blueprint $table) {
            $table->id();
            // $table->foreignId("rawid")->constrained("rawmaterials");
            $table->foreignId('purchases_id')->constrained("purchasesbills")->onDelete('cascade');
            $table->double("qoun",15, 8);
            $table->double("descont",15, 8);
            $table->double("total",15, 2)->nullable();
            $table->foreignId("rawmati")->constrained("rawmaterials");
            $table->foreignId("user_id")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases_items');
    }
};

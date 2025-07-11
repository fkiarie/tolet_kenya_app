<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('buildings', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('city');
        $table->string('town');
        $table->foreignId('landlord_id')->constrained()->onDelete('cascade');
        $table->json('unit_types'); // ex: ["1 bedroom", "shop"]
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};

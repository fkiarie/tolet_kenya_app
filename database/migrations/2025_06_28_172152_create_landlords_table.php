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
    Schema::create('landlords', function (Blueprint $table) {
        $table->id();
        $table->string('full_name');
        $table->string('business_name')->nullable();
        $table->string('phone');
        $table->string('email')->unique();
        $table->string('id_number');
        $table->string('photo'); // stored path
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlords');
    }
};

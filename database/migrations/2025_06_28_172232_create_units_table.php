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
    Schema::create('units', function (Blueprint $table) {
        $table->id();
        $table->foreignId('building_id')->constrained()->onDelete('cascade');
        $table->string('unit_type');
        $table->enum('status', ['vacant', 'occupied', 'under maintenance'])->default('vacant');
        $table->decimal('rent', 10, 2);
        $table->decimal('deposit', 10, 2);
        $table->date('lease_date')->nullable();
        $table->date('end_lease')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};

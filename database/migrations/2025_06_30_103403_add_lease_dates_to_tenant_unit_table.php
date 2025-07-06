<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('tenant_unit', function (Blueprint $table) {
        $table->date('lease_date')->nullable();
        $table->date('end_of_lease')->nullable();
    });
}

public function down()
{
    Schema::table('tenant_unit', function (Blueprint $table) {
        $table->dropColumn(['lease_date', 'end_of_lease']);
    });
}
};


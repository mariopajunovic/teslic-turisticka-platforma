<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->json('drustvene')->nullable()->after('kontakt');
            $table->json('usluge')->nullable()->after('drustvene');
            $table->string('cijena_raspon', 8)->nullable()->after('usluge');
            $table->unsignedSmallInteger('godina_osnivanja')->nullable()->after('cijena_raspon');
            $table->json('nacin_placanja')->nullable()->after('godina_osnivanja');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['drustvene', 'usluge', 'cijena_raspon', 'godina_osnivanja', 'nacin_placanja']);
        });
    }
};

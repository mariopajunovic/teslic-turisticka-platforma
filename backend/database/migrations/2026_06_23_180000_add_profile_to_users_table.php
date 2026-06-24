<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('biznis')->after('email');
            $table->string('status')->default('na_odobrenju')->after('role');
            $table->string('telefon')->nullable()->after('status');
            $table->text('bio')->nullable()->after('telefon');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'telefon', 'bio']);
        });
    }
};

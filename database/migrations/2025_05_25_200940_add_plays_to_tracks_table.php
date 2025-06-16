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
    Schema::table('tracks', function (Blueprint $table) {
        $table->unsignedBigInteger('plays')->default(0)->after('duration');
    });
}

public function down(): void
{
    Schema::table('tracks', function (Blueprint $table) {
        $table->dropColumn('plays');
    });
}

};

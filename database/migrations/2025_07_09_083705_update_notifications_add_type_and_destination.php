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
        //
            Schema::table('notifications', function (Blueprint $table) {
                 $table->string('notification_type');
                 $table->string('recipient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('notification_type');
            $table->dropColumn('recipient');
        });
    }
};

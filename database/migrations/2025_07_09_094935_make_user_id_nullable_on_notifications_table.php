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
        $table->dropForeign(['user_id']); // 👈 أول حاجة نفك ال foreign key
        $table->unsignedBigInteger('user_id')->nullable()->change(); // 👈 بعدين نعمله nullable
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users');
     });
    }
};

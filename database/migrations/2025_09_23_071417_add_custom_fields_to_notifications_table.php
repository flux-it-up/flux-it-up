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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('title')->nullable()->after('type');
            $table->string('icon')->nullable()->after('title');
            $table->string('color')->default('blue')->after('icon');
            $table->string('action_url')->nullable()->after('data');
            $table->string('action_text')->nullable()->after('action_url');
            $table->string('level')->default('info')->after('color');
            $table->string('priority')->default('normal')->after('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['title', 'icon', 'color', 'action_url', 'action_text', 'level', 'priority']);
        });
    }
};

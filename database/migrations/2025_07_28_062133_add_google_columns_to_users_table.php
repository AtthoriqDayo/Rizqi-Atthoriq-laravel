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
         Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->unique()->nullable()->after('id');
            $table->string('avatar')->nullable()->after('email');
            $table->text('google_token')->nullable()->after('avatar');
            $table->text('google_refresh_token')->nullable()->after('google_token');
            $table->string('role')->default('user')->after('remember_token'); // 'user' or 'admin'
            $table->string('password')->nullable()->change(); // Make password nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar', 'google_token', 'google_refresh_token', 'role']);
            $table->string('password')->nullable(false)->change();
        });
    }
};

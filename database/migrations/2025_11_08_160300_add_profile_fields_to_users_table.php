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
            $table->string('phone', 15)->nullable()->after('email');
            $table->string('nim', 20)->nullable()->after('phone');
            $table->string('jurusan', 100)->nullable()->after('nim');
            $table->string('angkatan', 4)->nullable()->after('jurusan');
            $table->string('profile_photo')->nullable()->after('angkatan');
            $table->boolean('is_active')->default(1)->after('profile_photo');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'nim',
                'jurusan',
                'angkatan',
                'profile_photo',
                'is_active',
                'last_login_at'
            ]);
        });
    }
};
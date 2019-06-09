<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppPhoneFiledToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->boolean('phone_verified')->default(false)->after('phone');
            $table->string('phone_verify_token')->nullable()->after('phone_verified');
            $table->timestamp('phone_verify_token_expire')->nullable()->after('phone_verify_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('phone_verified');
            $table->dropColumn('phone_verify_token');
            $table->dropColumn('phone_verify_token_expire');
        });
    }
}

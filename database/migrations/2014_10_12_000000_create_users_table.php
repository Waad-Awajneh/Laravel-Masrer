<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('gender');
            $table->string('bio')->default(" ");
            $table->string('major')->default(" ");
            $table->string('role')->default("user");
            $table->string('address');
            $table->binary('cover_Img')->nullable(); //should have a default
            $table->binary('profile_Img')->nullable(); //should have a default
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement(" ALTER TABLE `users` CHANGE `cover_Img` `cover_Img` MEDIUMBLOB NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `users` CHANGE `profile_Img` `profile_Img` MEDIUMBLOB NULL DEFAULT NULL");;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

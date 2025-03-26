<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username');
            $table->string('full_names')->nullable();
            $table->enum('gender',['male','female','others'])->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('status')->default(1);
            $table->text('image')->nullable();
            $table->text('bio')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $data = [
            [
            'username' => 'admin@admin.com',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('admin@admin.com'),
            'status'=>1,
            ],
            [
                'username' => 'User',
                'email' => 'user@user.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('user@user.com'),
                'status'=>1,
            ]
            ];
        \DB::table('users')->insert($data);
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

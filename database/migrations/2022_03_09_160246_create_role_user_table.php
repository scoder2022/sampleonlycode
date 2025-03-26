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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });

        $data = [
            [
                'name'=>'Admin',
                'key'=>'admin',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Product Admin',
                'key'=>'product_admin',
                'guard_name'=>'web'
            ],
            [
                'name'=>'User',
                'key'=>'user',
                'guard_name'=>'web'
            ]
            ];
        \DB::table('roles')->insert($data);
        $data = [
            [
                'role_id'=>"1",
                'user_id'=>"1"
            ],
            [
                'role_id'=>"2",
                'user_id'=>"2"
            ],
            [
                'role_id'=>"3",
                'user_id'=>"3"
            ],
            [
                'role_id'=>"3",
                'user_id'=>"1"
            ]

            ];
        \DB::table('role_user')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
};

<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $me = User::create([
            "nickName"        => "Nathan Lehman",
            "email"           => "nlehman06@gmail.com",
            "password"        => null,
            "provider"        => "facebook",
            "provider_id"     => "10157454457229778",
            "avatar"          => "https://graph.facebook.com/v2.10/10157454457229778/picture?type=normal",
            "activation_code" => null,
            "status"          => 1,
        ]);

        $me->assignRole('admin');
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Dirape\Token\Token;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        User::create([
        	'user_name' => 'ahihi',
            'nick_name' =>'ahihi',
            'gender' => 0,
            'password' => md5('123456'),
            'api_token' => (new Token())->Unique('users', 'api_token', 60),
        ]);

        factory(User::class, 99)->create();
        Model::reguard();
    }
}

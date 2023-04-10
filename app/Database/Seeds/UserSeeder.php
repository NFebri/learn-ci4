<?php

namespace App\Database\Seeds;

use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Entities\User;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = model(UserModel::class);
        $groupModel = model(GroupModel::class);

        $user = new User([
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => 'password'
        ]);

        $userModel->save($user->activate());

        $admin = $userModel->where('username', 'admin')->first();
        $group = $groupModel->where('name', 'admin')->first();

        $groupModel->addUserToGroup($admin->id, $group->id);
    }
}

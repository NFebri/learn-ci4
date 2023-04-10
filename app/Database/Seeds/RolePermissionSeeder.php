<?php

namespace App\Database\Seeds;

use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Admin'],
            ['name' => 'user', 'description' => 'Regular User']
        ];

        $groupModel = model(GroupModel::class);
        $groupModel->insertBatch($roles);

        $permissionModel = model(PermissionModel::class);

        $permissions = [
            ['name' => 'news-show', 'description' => 'show news data'],
            ['name' => 'news-create', 'description' => 'create news data'],
            ['name' => 'news-edit', 'description' => 'edit news data'],
            ['name' => 'news-delete', 'description' => 'delete news data'],
            ['name' => 'users-show', 'description' => 'show users data'],
            ['name' => 'users-create', 'description' => 'create users data'],
            ['name' => 'roles-show', 'description' => 'show roles data'],
            ['name' => 'roles-edit', 'description' => 'edit roles data'],
        ];

        $permissionModel->insertBatch($permissions);

        $admin_role = $groupModel->where('name', 'admin')->first();

        foreach ($permissionModel->findAll() as $permission) {
            $groupModel->addPermissionToGroup($permission->id, $admin_role->id);
        }
    }
}

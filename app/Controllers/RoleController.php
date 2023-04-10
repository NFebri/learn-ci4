<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class RoleController extends BaseController
{
    public function index()
    {
        return view('role/index', [
            'title' => 'Roles'
        ]);
    }

    public function getDatatables()
    {
        $roles = db_connect()->table('auth_groups')->select(['id', 'name']);

        return DataTable::of($roles)
            ->add('action', function($row){
                $action = '';
                if (has_permission('roles-edit')) {
                    $action .= '
                    <a href="' . route_to('roles_edit', $row->id) . '" class="btn btn-info btn-sm">
                        Edit
                    </a>';
                }
                return $action;
            }, 'last')
            ->toJson(true);
    }

    public function edit(int $id)
    {
        $group_model = model(GroupModel::class);
        return view('role/edit', [
            'title' => 'Edit Role',
            'role' => $group_model->find($id),
            'role_permissions' => array_column($group_model->getPermissionsForGroup($id), 'id'),
            'permissions' => model(PermissionModel::class)->findAll()
        ]);
    }

    public function update(int $id)
    {
        $request = $this->request->getPost(['name', 'description', 'permissions']);
        $group_model = model(GroupModel::class);

        if (!$this->validate($group_model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $group_model->update($id, $request);

        // detach all permissions from group
        db_connect()->table('auth_groups_permissions')->where('group_id', $id)->delete();

        // attach selected permissions to group
        foreach ($request['permissions'] as $permission) {
            $group_model->addPermissionToGroup($permission, $id);
        }

        return redirect()->route('roles_index')->with('message', 'role was updated');
    }
}

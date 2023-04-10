<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        return view('user/index', [
            'title' => 'Users'
        ]);
    }

    public function getDatatables()
    {
        $users = db_connect()->table('users')->select(['email', 'username']);

        return DataTable::of($users)
            ->toJson(true);
    }

    public function create()
    {
        return view('user/create', [
            'title' => 'Create User',
            'roles' => model(GroupModel::class)->findAll()
        ]);
    }

    public function store()
    {
        $request = $this->request->getPost(['email', 'username', 'password_hash', 'role_id']);
        $user_model = model(UserModel::class);
        $group_model = model(GroupModel::class);

        if (!$this->validate(array_merge($user_model->validationRules, ['role_id' => 'required']))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User($request);

        $user_model->insert($user->activate());
        $group_model->addUserToGroup($user_model->getInsertID(), $request['role_id']);

        return redirect()->route('users_index')->with('message', 'users was created');
    }
}

<?php

use App\Helpers\Helper;
use App\Models\Permission_Category;
use Illuminate\Support\Facades\Auth;

function RolePermission($controller, $name)
{
    $role = Permission_Category::where("name", $name)->first();
    if ($role) {
        $permissions = $role->getPermissions();
        foreach ($permissions as $permission) {
            $middlewareName = 'permission:' . $permission->name;
            $only = [];

            if ($permission->name === $name." View") {
                $only[] = 'index';
            } 
            if ($permission->name === $name." Create") {
                $only[] = 'create';
                $only[] = 'store';
            }
            if ($permission->name === $name." Edit") {
                $only[] = 'update';
                $only[] = 'edit';
            }
            if ($permission->name === $name." Delete") {
                $only[] = 'destroy';
            }
            if ($permission->name === $name." Show") {
                $only[] = 'show';
            }
            if ($permission->name === $name." Import") {
                $only[] = 'import';
            }
            if ($permission->name === $name." Export") {
                $only[] = 'export';
            }
            if ($permission->name === $name." Print") {
                $only[] = 'print';
            }
            if ($permission->name === $name." Approv") {
                $only[] = 'approve';
            }

            if (!empty($only)) {
                $controller->middleware($middlewareName, ['only' => $only]);
            }
        }
    }else {
        $controller->middleware('permission:' . $name. 'View', ['only' => []]);
    }
}
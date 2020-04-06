<?php
/**
 * Created by PhpStorm.
 * User: weishanyun
 * Date: 2020/4/2
 * Time: 0:40
 */

namespace App\Models;


use Spatie\Permission\Traits\HasPermissions;
use Spatie\QueryBuilder\QueryBuilder;

class Role extends \Spatie\Permission\Models\Role
{
    protected $appends = [
        'permissions_ids',
        'menulisttree'
    ];

    protected $hidden = [
        'permissions',
        'menulist'
    ];

    //获取角色拥有的权限ID数组
    public function getPermissionsIdsAttribute()
    {
        $permissionsIds= array_column(json_decode(json_encode($this->permissions),true),'id');
        return $permissionsIds;
    }

    //获取角色拥有的需要展示的菜单返回树形结构
    public function getMenulisttreeAttribute()
    {
        return $this->menulist;
    }

    /**
     * A role may be given various menulist.
     */
    public function menulist()
    {
        $roles = $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            'role_id',
            'permission_id'
        )->with(['childrenlist'])
        ->where(['pid'=>0,'is_show'=>1]);
        return $roles;
    }


}
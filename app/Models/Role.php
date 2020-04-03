<?php
/**
 * Created by PhpStorm.
 * User: weishanyun
 * Date: 2020/4/2
 * Time: 0:40
 */

namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{
    protected $appends = [
        'permissions_ids'
    ];

    protected $hidden = [
        'permissions'
    ];


    public function getPermissionsIdsAttribute()
    {
        $permissionsIds= array_column(json_decode(json_encode($this->permissions),true),'id');
        return $permissionsIds;
    }
}
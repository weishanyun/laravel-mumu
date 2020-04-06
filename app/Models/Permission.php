<?php
/**
 * Created by PhpStorm.
 * User: weishanyun
 * Date: 2020/4/2
 * Time: 0:40
 */

namespace App\Models;


class Permission extends \Spatie\Permission\Models\Permission
{

    //获取所有权限生成树形
    public function children()
    {
        return $this->hasMany(Permission::class, 'pid','id')->with('children');
    }
    //获取显示菜单
    public function childrenlist()
    {
        return $this->hasMany(Permission::class, 'pid','id')->with('childrenlist')->where(['is_show'=>1]);
    }

}
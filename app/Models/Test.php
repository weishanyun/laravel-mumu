<?php
/**
 * Created by PhpStorm.
 * User: weishanyun
 * Date: 2020/4/7
 * Time: 22:39
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class Test extends Model
{
    protected $table = 'test1';

    protected $connection = 'mysql';

    protected $fillable = ['id','title','centent'];


    public function mySetConnection($connection)
    {
        $this->connection = $connection;
    }

    public function add()
    {
        //$lastID一定要做持久化
        $lastID = Cache::pull('lastID',null);
        if(!$lastID)
        {
            Cache::set('lastID',0);
        }
        $connection = ($lastID+1) % 2 ==0 ?'mysql2':'mysql';
        $this->setConnection($connection);
        echo $lastID+1;
        $this->insert([
            'id'=>$lastID+1,
            'title'=>'测试测试'.($lastID+1),
            'centent'=>'test'
        ]);
        Cache::set('lastID',$lastID+1);
    }

    public function getList($whre=[],$page=0,$pageSzie=20)
    {
        $startID =  $page * $pageSzie;

        $arr1 = $this->where('id','>=',$startID)->where($whre)->take($pageSzie/2)->get();

        $this->mySetConnection('mysql2');
        $arr2 = $this->where('id','>=',$startID)->where($whre)->take($pageSzie/2)->get();

        return $arr1->concat($arr2)->sortBy('id');
    }
}
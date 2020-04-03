<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role as Model;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $list = Model::select()->paginate($request->get('pageSize'),['*'],'page');
        return response()->json(['code'=>1,'msg'=>'成功','data'=>$list]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Model::find($id);
        return response()->json(['code'=>1,'msg'=>'成功','data'=>$model]);
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $data = $request->only(['name','guard_name','slug']);
        $model = new Model($data);
        $model->save();

        if($request->permission_ids)
        {
            $model->syncPermissions(Permission::find($request->permission_ids));
        }
        return response()->json(['code'=>1,'msg'=>'成功','data'=>$model]);
    }


    /**
     * Update a newly created resource in storage.
     *
     */
    public function update(Request $request)
    {
        $data = $request->only(['name','guard_name']);
        $model = Model::find($request->id);
        $model->update($data);
        return response()->json(['code'=>1,'msg'=>'成功','data'=>$model]);
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function destroy($id)
    {

    }
}

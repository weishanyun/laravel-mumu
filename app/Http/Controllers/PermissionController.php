<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission as Model;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $list = Model::with('children')->where(['pid'=>0])->get();
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
        $data = $request->only(['pid','name','slug','path','guard_name']);
        $model = new Model($data);
        $model->save();
        return response()->json(['code'=>1,'msg'=>'成功','data'=>$model]);
    }


    /**
     * Update a newly created resource in storage.
     *
     */
    public function update(Request $request)
    {
        $data = $request->only(['pid','name','slug','path','guard_name']);
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

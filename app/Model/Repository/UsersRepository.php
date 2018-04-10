<?php
/**
 * Created by PhpStorm.
 * User: elipdat
 * Date: 4/6/2018
 * Time: 2:08 PM
 */

namespace App\Model\Repository;



use App\Http\Requests\ImportfileRequest;
use App\Http\Requests\UpdateliststatusRequest;
use App\Http\Requests\UsersRequest;
use App\Model\Nguoidung;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;


class UsersRepository
{
    public static function insertUser(UsersRequest $request){
        $nd = new Nguoidung();
        $nd->ho = $request->input("ho");
        $nd->ten = $request->input("ten");
        $nd->dia_chi = $request->input("dia_chi");
        $nd->tai_khoan = $request->input("tai_khoan");
        if($request->has("auth"))
        {
            $nd->auth = (int)$request->input("auth");
        }
        $nd->password = Hash::make($request->input("password"));
        $nd->save();
        return true;

    }
    public static function getUser($id)
    {
        return Nguoidung::find($id);
    }
    public static function updateUser(UsersRequest $request,$id)
    {

        $nd = Nguoidung::findOrFail($id);
        $nd->ho = $request->input("ho");
        $nd->ten = $request->input("ten");
        $nd->dia_chi = $request->input("dia_chi");
        if($request->has("password"))
        {
            $nd->password = Hash::make($request->input("password"));
        }
        if($request->has("auth"))
        {
            $nd->auth = $request->auth;
        }
        $nd->trang_thai = (int)$request->input("trang_thai");
        $nd->update();
        return true;
    }
    public static function getAllUser()
    {
        $nd = new Nguoidung();
        return $nd->where("id","!=",Auth::guard("login")->user()->id)->get();

    }
    public static function updatelistStatus(UpdateliststatusRequest $request)
    {

        foreach ($request->list as $item)
        {
            $nd = Nguoidung::findOrFail($item["id"]);
            $nd->trang_thai = $item["trang_thai"];
            $nd->update();
        }
        return true;
    }
    public  static function  importlistuser(ImportfileRequest $request)
    {
        $data = [];

        $data_ = Excel::load($request->file("file"),function ($reader){
            $reader->all();
        })->get();
        $arr_dub = [];
        foreach ($data_ as $key => $item)
        {
            if(Nguoidung::where("tai_khoan",$item->tai_khoan)->first() != null)
            {
                $arr_dub[] = $item;
            }
            else{
                $data[] = ["ho" => $item->ho,"ten" => $item->ten,"dia_chi" => $item->dia_chi,"password" => Hash::make($item->password),"auth" => $item->auth != null?$item->auth:0,"tai_khoan" => $item->tai_khoan];

            }

        }
        if(count($arr_dub) > 0)
        {
            return $arr_dub;
        }
        try{
            DB::table("nguoi_dung")->insert((array)$data);
        }catch (QueryException $e)
        {
            return $e;
        }

        return true;
    }


}
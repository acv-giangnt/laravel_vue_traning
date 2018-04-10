<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportfileRequest;
use App\Http\Requests\UpdateliststatusRequest;
use App\Http\Requests\UsersRequest;
use App\Model\Nguoidung;
use App\Model\Repository\UsersRepository;
use App\Model\Services\UsersService;
use Illuminate\Support\Facades\Auth;


class NguoidungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return UsersService::getAllUser();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {

        return ["sc" => UsersService::insertUser($request)];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::guard("login")->user()->id == $id || Auth::guard("login")->user()->auth)
        {
            return UsersService::getUser($id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        return ["sc" => UsersRepository::updateUser($request,$id)];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nd = new Nguoidung();
        $nd = $nd->find($id);
        if($nd)
        {
            $nd->delete();
            return ["sc" => true];
        }
        return ["sc" => false];
    }
    public function update_status_list_user(UpdateliststatusRequest $request)
    {

            return ["sc" => UsersService::updatelistStatus($request)];
    }
    public function add_list_user(ImportfileRequest $request)
    {
        return ["sc" => UsersService::importlistuser($request)];
    }
}

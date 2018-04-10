<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	
    return view('template');
});
Route::get("admin/danh-sach-nguoi-dung",["as" => "admin.danhsachnguoidung","uses" => "AdminController@danhsachnguoidung","middleware" => "login"]);
Route::get("/login",["as" => "login","uses" => "AdminController@login"]);
Route::post("api/login",["as" => "post.api.login","uses" => "LoginController@store"]);
Route::get("logout" ,["as" => "logout","uses" => function(){
    \Illuminate\Support\Facades\Auth::guard("login")->logout();
    return redirect()->guest(route('login'));
}]);
Route::resource('api/nguoi-dung','NguoidungController',["middleware"=> ["login","login.admin"],
    'only' => ['index','edit','create','store','update','destroy']
]);
Route::get("register",["as" => "get.register","uses" => "AdminController@register"]);
Route::post("register",["as" => "post.register","uses" => "AdminController@post_register"]);

Route::post("api/update-status-list-user","NguoidungController@update_status_list_user",["as"=>"api.nguoidung.update_status_list_user", "middleware"=> ["login","login.admin"]]);
Route::post("/api/add-list-user","NguoidungController@add_list_user",["as"=>"api.nguoidung.add_list_user", "middleware"=> ["login","login.admin"]]);




Route::get("api/nguoi-dung/{id}","NguoidungController@show",["as"=>"api.nguoidung.show.id", "middleware" => "login"]);
Route::get("/profile",["as" => "profile", "uses" =>function (){
   return view("profile",["id"=>\Illuminate\Support\Facades\Auth::guard("login")->user()->id]);
}]);
Route::put("/profile",function (\App\Http\Requests\UpdateprofileRequest $request){
    $nd = new \App\Model\Nguoidung();
    $nd = $nd->findOrFail(\Illuminate\Support\Facades\Auth::guard("login")->user()->id);
    $nd->ho = $request->ho;
    $nd->ten = $request->ten;
    $nd->dia_chi = $request->dia_chi;
    if($request->has("password"))
    {
        $nd->password = \Illuminate\Support\Facades\Hash::make($request->password);
    }
    $nd->save();
    return ["sc" => true];

});
Route::get("/test-csv",function (){

    $data = Excel::load("user.csv",function ($reader){
        $reader->all();
    })->get();
    return view("testcsv",["data" => $data]);
});
<?php
/**
 * Created by PhpStorm.
 * User: elipdat
 * Date: 4/6/2018
 * Time: 2:16 PM
 */

namespace App\Model\Services;




use App\Http\Requests\ImportfileRequest;
use App\Http\Requests\UpdateliststatusRequest;
use App\Http\Requests\UsersRequest;
use App\Model\Repository\UsersRepository;


class UsersService
{
    public static function getAllUser()
    {
        return UsersRepository::getAllUser();
    }
   public static function insertUser(UsersRequest $request)
   {

       return UsersRepository::insertUser($request);
   }
   public static function getUser($id)
   {
       return UsersRepository::getUser($id);
   }
   public static function updateUser(UsersRequest $request,$id)
   {
        return UsersRepository::updateUser($request,$id);
   }
   public static function updatelistStatus(UpdateliststatusRequest $request)
   {
       return UsersRepository::updatelistStatus($request);
   }
   public static function importlistuser(ImportfileRequest $request)
   {
       return UsersRepository::importlistuser($request);
   }

}
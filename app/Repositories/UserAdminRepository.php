<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAdminRepository
{
    public function auth($request)
    {
 
    }
    public function create($request)
    {
        $loginData = Validator::make($request->all(), [
            'name' => 'required|',
            'email' => 'required|unique:users',
            'password' => 'required|min:4',
        ]);
        if (isset($loginData) && $loginData->fails()) {
            return response()->json(['status' => false, 'message' => $loginData->errors()->first()]);
        } else {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
        }
        return $user;
    }
    public function update($request, $id)
    {
      
        return;
    }
    public function delete($id)
    {
        $data = User::findOrFail($id);
        $user = $data->delete();
        return $user;
    }

    //if one status is active other status didnt active//////
    public function status()
    {
        $abc = User::where('status', '1')->first();
        if ($abc == null) {
            $abc = '0';
        } else {
            $abc = '1';
        }
        if (isset($abc) && $abc != 1) {
            dd('pass');
        } else {
            dd('fail');
        }
    }
}

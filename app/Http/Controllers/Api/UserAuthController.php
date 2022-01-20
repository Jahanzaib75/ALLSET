<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserAdminRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    private $useradminrepository;

    public function __construct(UserAdminRepository $useradminrepository)
    {

        $this->useradminrepository = $useradminrepository;
    }

    /////////Register User////////////////
    public function register(Request $request)
    {
        $user =  $this->useradminrepository->create($request);
        if ($user) {
            return response(['status' => true, 'message' =>  'User registered successfully'], 200);
        } else {
            return response(['status' => false, 'message' => 'User registration failed'], 200);
        }
    }
    ///////////////////User login??////////////////////
    public function auth(Request $request)
    {
        $loginData = Validator::make($request->all(), [
            'email' => 'required|exists:users',
            'password' => 'required'
        ]);
        if (isset($loginData) && $loginData->fails()) {
            return response()->json(['status' => false, 'message' => $loginData->errors()->first()]);
        } else {
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::guard('web')->user();

                $token = $user->createToken('MyApp')->accessToken;

                return response(['status' => true, 'message' =>  'Login Successfull', 'user' => $user, 'token' => $token],  200);
            } else {
                return response(['status' => false, 'message' =>  'Inccorect credentiales'], 200);
            }
        }
    }
    /// Logout ////////
    public function indexlogout()
    {
        dd('ok');
        Auth::logout();
        Session()->flush();
        return response(['status' => true, 'message' =>  'Logout'],  200);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginStoreRequest;
use App\Http\Requests\Web\RegistrationStoreRequest;
use App\Repositories\Web\UserRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ApiResponser;

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(RegistrationStoreRequest $request)
    {
        $params = $this->user->getNewParam($request);
        $data = $this->user->create($params);

        return $this->success($data,'Register Success');
    }

    public function login(LoginStoreRequest $request)
    {
        if (\Auth::attempt($request->only(["email", "password"]))) {
            
            return $this->success(url("home"),'Login Success');
        } 
            
        return $this->error('Invalid credentials',422);
    }
}

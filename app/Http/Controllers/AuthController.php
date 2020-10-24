<?php

namespace App\Http\Controllers;
use App\Employee;
use App\Http\Requests\signupRequest;
use App\People;
use App\Role;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login','signup']]);
//    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'error' => 'Email or Password does not exist'
            ],
                401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(signupRequest $request)
    {
        $user = User::create($request->all());
        return $this->login($request);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        $user->makeHidden(['created_at','updated_at','email_verified_at']);
        $roles = implode(',',auth()->user()->roles()->get()->pluck('value')->toArray());
        $myArray = explode(',', $roles);
        return response()->json([
            'token' => $token,
            'success' => true,
            'user' => $user,
            'roles'=> $myArray,
            'department'=>$user->department,
            'zita'=>$user->name
        ]);
    }

    public function creatUsers()
    {
        $alls = Employee::all();
        foreach ($alls as $all)
        {
            $user = User::create([
                'name' => $all->name,
                'email' => $all->email,
                'password'=>$all->city,
            ]);
            $role = Role::select('id')->where('name','user')->first();
            $user->roles()->attach($role);
        }
    }

    public function allUsers()
    {
        $users = User::all();
        $users->makeHidden(['created_at','updated_at','email_verified_at']);
        $users_array = [];
        foreach ($users as $user)
        {
            $roles = implode(',',$user->roles()->get()->pluck('value')->toArray());
            $myArray = explode(',', $roles);
            $users_array[]= [
                'name' => $user->name,
                'id' => $user->id,
                'email' => $user->email,
                'department' => $user->department,
                'division' => $user->division,
                'roles' => $roles,
            ];
        }
        return $users_array;

    }

    public function allRoles()
    {
        $roles = Role::all();
        $roles->makeHidden(['created_at','updated_at']);
        return $roles;
    }

    public function editRoles(Request $request)
    {
        $roles = $request->roles;
        $user = User::where('id',$request->munhu)->first();
        $user->roles()->sync($roles);
    }
    public function allStaff()
    {
        $staffs = People::all();
        foreach ($staffs as $staff)        {
            $user =  User::create(
                [
                    'name' => $staff->name,
                    'password' => $staff->plain,
                    'email' => $staff->email,
                    'department' =>$staff->department
                ]
            );
        }

    }
}

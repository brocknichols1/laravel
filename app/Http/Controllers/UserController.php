<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Address;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * 
     * @param Request $request
     * @return object
     */
    public function createUser(Request $request)
    {
        print_r('here'); exit;
        $validator = Validator::make($request->json()->all() , [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:2',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->json()->get('username'),
            'email' => $request->json()->get('email'),
            'password' => Hash::make($request->json()->get('password')),
            'organization_id' => $request->json()->get('organization_id'),
        ]);
        
        $role = Role::create(['user_id' => $user->id, 'user_role' => $request->json()->get('role')]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }


    /**
     * Show User
     * 
     * @param int $id
     * @return object
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json(compact('user'));
    }

    /**
     * 
     * @param int $id
     * @return object
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return response()->json(compact('user','roles','userRole'));
    }

    /**
     * Update the user
     * 
     * @param Request $request
     * @return object
     */
    public function update(Request $request)
    {
        $this->validate($request->id, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = User::find($request->id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$request->id)->delete();

        $user->assignRole($request->input('roles'));

        $status = ['success' => true, 'msg' => 'User updated successfully'];
        return response()->json(compact('status'));
    }

    /**
     * Delete the user
     * 
     * @param int $id
     * @return object
     */
    public function delete($id)
    {
        User::find($id)->delete();

        $success = ['success'=>'User updated successfully'];
        return response()->json(compact('success'));
    }

    /**
     * Get Users excluding the requested
     * 
     * @param int $id
     * @return object
     */
    public function getUsers($id)
    {
        // Exclude the current user id
        $users = User::with(['profile', 'address', 'organization', 'role'])->get()->except($id);
        return response()->json(compact('users'));
    }

    /**
     * Login User
     * 
     * @param Request $request
     * @return object
     */
    public function login(Request $request)
    {
        $credentials = $request->json()->all();

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json( compact('token') );
    }

    /**
     * Run user through authentication
     * 
     * @return type
     */
    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $user->profile;
                $user->address;
                $user->organization;
                $user->role;
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

}

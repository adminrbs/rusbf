<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Exception;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class UserController extends Controller
{

    public function get_user_role()
    {
        try {
            $quary = "SELECT * FROM roles ";
            $result = DB::select($quary);
            return response()->json($result);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function save_user(Request $request)
    {

        try {
            $user = new User();
            $user->name = $request->get('username');
            $user->email = $request->get('email');
            $user->user_type = $request->get('usertype');
            $user->password = Hash::make($request->get('password'));


            if ($user->save()) {
                $user_role = new UserRole();
                $user_role->user_id = $user->id;
                $user_role->role_id = $request->get('userrole');
                $user_role->save();

                return response()->json(["status" => "saved"]);
            } else {
                return response()->json(["status" => "failed"]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function view_users_list()
    {

        return view('view_all_users');
    }

    public function load_users_list()
    {

        try {

            $userData = DB::table("users")
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.user_type',
                    'roles.name AS role_name' // Include the role name from the roles table
                )
                ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id') // Join the roles table
                ->get();


            return compact('userData');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    // public function get_user_data($id){

    //     try{

    //         $data = DB::table("users")
    //                     ->select('users.id','users.name','users.email','users.user_type','users.password')
    //                     ->where('id', $id)
    //                     ->first();

    //         $role_name = DB::table('users_roles')
    //                         ->select('roles.id','roles.name')
    //                         ->join('roles', 'users_roles.role_id', '=', 'roles.id')
    //                         ->where('users_roles.user_id', $id)
    //                         ->first();

    //         return [$data, $role_name];

    //     }catch(Exception $ex) {
    //         return $ex->getMessage();
    //     }
    // }

    public function change_password(Request $request, $id)
    {

        try {

            $user = User::find($id);

            if (!$user) {
                return response()->json(["status" => "failed"]);
            }

            $currentPassword = $request->get('current_pwd');

            // Check if the typed current password matches the existing password
            if (!Hash::check($currentPassword, $user->password)) {
                return response()->json(["status" => "incorrect_password"]);
            } else {
                $newPassword = $request->get('new_pwd');
                $user->password = Hash::make($newPassword);
                $user->save();
                return response()->json(["status" => "success"]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function get_user_data($id)
    {

        try {
            $quary = "SELECT U.id, U.name, U.email, U.user_type, R.id AS role_id, R.name AS role_name
FROM users U
INNER JOIN users_roles UR ON UR.user_id = U.id
INNER JOIN roles R ON R.id = UR.role_id
WHERE U.id =$id";

            $result = DB::select($quary);
            return response()->json($result);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function update_user(Request $request, $id)
    {

        try {



            $inputPassword = $request->get('password');

            if ($inputPassword  != null) {

                $user = User::findOrFail($id);
                // if ($inputPassword) {
                if ($user) {

                    $user->name = $request->get('username');
                    $user->email = $request->get('email');
                    $user->user_type = $request->get('usertype');
                    $user->password = Hash::make($request->get('password'));
                    $user->update();

                    $userRoleId = $request->input('userrole');
                    $userId = $user->id;

                    $query = "UPDATE `users_roles` SET `role_id` = '$userRoleId' WHERE `user_id` = $userId";

                    $result = \DB::statement($query);



                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['error' => 'User not found']);
                }
            } else {
                $user = User::findOrFail($id);


                $user->name = $request->get('username');
                $user->email = $request->get('email');
                $user->user_type = $request->get('usertype');
                //$user->password = Hash::make($request->get('password'));
                $user->save();



                $userRoleId = $request->input('userrole');
                $userId = $user->id;

                $query = "UPDATE `users_roles` SET `role_id` = '$userRoleId' WHERE `user_id` = $userId";

                $result = \DB::statement($query);



                return response()->json($result);
            }


















            /* $password = $request->password;
            if ($password != null) {
                $user = User::findOrFail($id);
                $user->name = $request->get('username');
                $user->email = $request->get('email');
                $user->user_type = $request->get('usertype');
                $user->password = Hash::make($request->get('password'));

                $user->update();
                return response()->json($user);
            } else {
                $user = User::findOrFail($id);
                $user->name = $request->get('username');
                $user->email = $request->get('email');
                $user->user_type = $request->get('usertype');
                $user->update();
                return response()->json($user);
            }*/
        } catch (Exception $ex) {

            return $ex;
        }
    }


    public function deleteusers($id){
        try {

           $user = User::find($id);

            $user->delete();
    
           $quary="DELETE FROM users_roles WHERE users_roles.user_id=$id";
           $result = \DB::statement($quary);
    
            return response()->json(['success' => 'Record has been deleted']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    
}

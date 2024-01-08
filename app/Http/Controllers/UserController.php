<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;

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

            $userData = DB::select("SELECT
            U.id,
            U.name,
            U.email,
            CASE WHEN U.user_type = 1 THEN 'Employee' ELSE 'User' END AS user_type,
            R.name AS role_name
        FROM
            users U
        LEFT JOIN
            users_roles US ON US.user_id = U.id
        LEFT JOIN
            roles R ON R.id = US.role_id;
        ");


            return response()->json($userData);
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
            LEFT JOIN users_roles UR ON UR.user_id = U.id
            LEFT JOIN roles R ON R.id = UR.role_id
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





            $user = User::findOrFail($id);

            $inputPassword = $request->get('password');

            if (Hash::check($inputPassword, $user->password) || $inputPassword == null) {


                if ($user) {
                    $user->name = $request->input('username');
                    $user->email = $request->input('email');
                    //$user->user_id = $request->input('cmbuEmployee');
                    // $user_type = $request->input('usertype');

                    $user->user_type = $request->input('usertype');
                    $user->save();


                    $userRoleId = $request->input('userrole');
                    $userRole = UserRole::where('user_id', $user->id)->firstOrFail();

                    if ($userRoleId !== 'null') {
                        $userRole->role_id = $userRoleId;
                        $userRole->save();
                    }

                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['error' => 'User not found']);
                }
            } else {

                if ($user) {
                    $user->name = $request->get('username');
                    $user->email = $request->get('email');
                    $user->password = Hash::make($request->get('password'));
                    $user_type = $request->input('usertype');
                    $user->user_type = ($user_type == 0) ? '0' : '1';
                    $user->save();


                    $userRoleId = $request->input('userrole');
                    $userRole = UserRole::where('user_id', $user->id)->firstOrFail();


                    if ($userRoleId !== 'null') {
                        $userRole->role_id = $userRoleId;
                        $userRole->save();
                    }

                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['error' => 'User not found']);
                }
            }


        } catch (Exception $ex) {

            return $ex;
        }
    }


    public function deleteusers($id)
    {
        try {

            $user = User::find($id);

            $user->delete();
            $userRole = UserRole::where('user_id', $id)->first();
            $userRole->delete();

            return response()->json(['success' => 'Record has been deleted']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}

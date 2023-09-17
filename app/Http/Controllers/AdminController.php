<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        $doctor = Doctor::all();
        return response()->json($doctor);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
                'status' => '422'
            ]);
        }

        if (Auth::guard('webadmin')->attempt($request->only('username', 'password'))) {
            /** @var \App\Models\Admin $user **/
            $user = Auth::guard('webadmin')->user();

            $token = $user->createToken('Admin')->accessToken;
            
            return response()->json([
                'message' => 'Successfully logged in!',
                'status' => '200',
                'token' => $token,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => '401',
            ]);
        }
    }

    public function add_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'no_telp' => ['required'],
            'alamat' => ['required'],
            'username' => ['required', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
            ], 422);
        }
        
        $admin = new Admin([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' =>  bcrypt($request->password),
        ]);
        $admin->save();

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $admin
        ], 200);
    }

    public function edit_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'no_telp' => ['required'],
            'alamat' => ['required'],
            'username' => ['required', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:8'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
            ], 422);
        }
        
        $id = Auth::user()->id;
        $admin = Admin::find($id);

        $admin->update([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' =>  bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Successfully updated user!',
            'user' => $admin,
        ], 200);
    }

    public function edit_patient(Request $request, $patient_username) {
        $patient = Patient::where('username', $patient_username)->first();

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:8'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'emergency_phone' => ['required', 'string'],
            'age' => ['required', 'numeric'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
                'status' => '422'
            ]);
        }

        $patient->update([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'emergency_phone' => $request->emergency_phone,
            'age' => $request->age,
            'gender' => $request->gender,
        ]);

        return response()->json([
            'message' => 'Successfully updated user!',
            'user' => $patient,
        ], 200);
    }

    public function delete_patient(Request $request, $patient_username)
    {
        $patient = Patient::where('username', $patient_username);
        $patient->delete();

        return response()->json([
            'message' => 'Successfully deleted user!',
            'user' => $patient,
        ], 200);
    }

    public function add_doctor(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'no_telp' => ['required'],
            'alamat' => ['required'],
            'username' => ['required', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
                'status' => '422'
            ], 422);
        }
        
        $doctor = new Doctor([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' =>  bcrypt($request->password),
        ]);
        $doctor->save();

        return response()->json([
            'message' => 'Successfully created user!',
            'status' => '200',
            'user' => $doctor
        ], 200);
    }

    public function edit_doctor(Request $request, $doctor_username) {
        $doctor = Doctor::where('username', $doctor_username)->first();

        $validator = Validator::make($request->all(), [
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'no_telp' => ['required'],
            'alamat' => ['required'],
            'username' => ['required', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
            ], 422);
        }

        $doctor->update([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' =>  bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Successfully updated user!',
            'user' => $doctor,
        ], 200);
    }

    public function delete_doctor(Request $request, $doctor_username)
    {
        $doctor = Doctor::where('username', $doctor_username);
        $doctor->delete();

        return response()->json([
            'message' => 'Successfully deleted user!',
            'user' => $doctor,
        ], 200);
    }

    public function logout(Request $request)
    {
         /** @var \App\Models\Admin $user **/
         $user = Auth::guard('apiadmin')->user();
         $accessToken = $user->token();
         DB::table('oauth_refresh_tokens')
             ->where('access_token_id', $accessToken->id)
             ->update(['revoked' => true]);
         $accessToken->revoke();
 
         return response()->json([
             'message' => 'Log Out Successful',
             'status' => 200,
             'data' => 'Unauthorized',
         ]);
    }
}

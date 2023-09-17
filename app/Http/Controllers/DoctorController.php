<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{
    public function index()
    {
        $patient = Patient::all();
        return response()->json($patient);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation failed',
                    'error' => $validator->errors(),
                    'status' => '422'
                ]
            );
        }

        if (Auth::guard('webdoctor')->attempt($request->only('username', 'password'))) {
            /** @var \App\Models\Doctor $user **/
            $user = Auth::guard('webdoctor')->user();

            $token = $user->createToken('Doctor')->accessToken;

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

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan' => ['required'],
            'nama_belakang' => ['required'],
            'no_telp' => ['required', 'string'],
            'alamat' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
                'status' => '422',
            ]);
        }

        $doctor = Doctor::find(Auth::user()->id);
        $doctor->update([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return response()->json([
            'message' => 'Successfully updated user!',
            'user' => $doctor,
        ], 200);
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
                'status' => '422'
            ]);
        }

        $doctor = Doctor::find(Auth::user()->id);
        $doctor->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Successfully updated user!',
            'user' => $doctor,
        ], 200);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\Doctor $user **/
        $user = Auth::guard('apidoctor')->user();
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; //panggil model user
use App\Models\Log;
use Firebase\JWT\JWT; //panggil library jwt
// use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Validator; //panggil library validator untuk validasi inputan
use Illuminate\Support\Facades\Auth; //panggil library untuk autentikasi
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{

    public function login(Request $request) {
        $validator = Validator::make($request->all(),[
            'username_tmu' => 'required|email',
            'password_tmu' => 'required'
        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }
        if(Auth::attempt($validator->validated())) {
            $payload = [
                'nama' => Auth::user()->name_tmu,
                'role' => Auth::user()->role_tmu,
                'iat' => now()->timestamp,
                'exp' => now()->timestamp + 7200
            ];
            $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');
            return response()->json([
                "data" => [
                    'msg' => "berhasil login",
                    'nama' => Auth::user()->name_tmu,
                    'email' => Auth::user()->username_tmu,
                    'role' => Auth::user()->role_tmu,
                ],
                "token" => "Bearer {$token}"
            ],200);
        }
        return response()->json("email atau password salah", 422);
    }


    public function register(Request $request) {

        //buat validasi inputan
        $validator = Validator::make($request->all(),[
            'nik_tmu' => 'required',
            'name_tmu' => 'required',
            'username_tmu' => 'required|email|unique:tbl_m_user,username_tmu',
            'password_tmu' => 'required|min:8'
        ]); 
        //ketika satu atau lebih inputan tidak sesuai di atas
        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        $user = $validator -> validated();
        // untuk has pasword kolom password 'password_tmu'
        // $user['password_tmu'] = bcrypt($user['password_tmu']);

        // masukan ke database tabel user
        User::create($user);

        // isi token jwt
        $payload = [
            'nama' => $user['name_tmu'],
            'role' => "user",
            'iat' => now() -> timestamp, //waktu dibuat token
            'exp' => now() -> timestamp + 7200 //waktu dibuat token setelah 2 jam
        ];

        //generate token dengan algoritma HS256
        $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');

        //BUAT Regis
        // Log::create([
        //     'module' => 'Register',
        //     'action' => 'Registrasi akun',
        //     'useraccess' => $user['username_tmu']
        // ]);

        // kirim response ke pengguna
        return response()->json([
            "data" => [
                'msg' => 'Berhasil Register Dari Pengguna',
                'nama' => $user['name_tmu'],
                'email' => $user['username_tmu'],
                'role' => 'user',
            ],
            "token" => "Bearer {$token}"
        ],200);
    }
}

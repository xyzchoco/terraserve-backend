<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request)
    {
        try {
            // 1. Tambahkan validasi untuk 'phone' dan 'password_confirmation'
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:20'], // Tambahkan ini
                'password' => ['required', 'string', 'confirmed', new Password], // 'confirmed' akan otomatis cek 'password_confirmation'
        ]);

        // 2. Tambahkan 'phone' dan 'roles' saat membuat user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // Tambahkan ini
            'roles' => 'USER', // Beri nilai default 'USER' untuk registrasi
            'password' => Hash::make($request->password),
        ]);

        // Kode Anda selanjutnya sudah benar
        $user = User::where('email', $request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'User Registered');
        
        } catch (Exception $error) {
            // Untuk debugging, Anda bisa menampilkan error aslinya
            return ResponseFormatter::error([
            'message' => 'Something went wrong',
            'error' => $error->getMessage(), // Tampilkan pesan error yang lebih jelas
        ], 'Authentication Failed', 500);
    }
}

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'    
                ], 'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();

            if(! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'User' => $user    
            ],'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error    
            ], 'Unauthenticated Failed', 500);
        }
    }

    public function fetch(Request $request) 
    {
        return ResponseFormatter::success($request->user(),'Data profile user berhasil diambil');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token,'Token Revoked');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'username' => ['sometimes', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', new Password],
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birthdate' => 'nullable|date',
        ]);

        $data = $request->all();

        // Jika password diisi, hash dulu
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan update password kalau kosong
        }

        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }

}


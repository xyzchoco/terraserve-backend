<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Handle forgot password request (sends OTP).
     */
    public function forgot(Request $request)
    {
        // 1. Validasi request
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        // 2. Buat OTP 6 digit
        $otp = random_int(1000, 9999);

        // 3. Simpan OTP (versi hash) ke database password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($otp), // Simpan versi hash, bukan OTP asli
                'created_at' => Carbon::now()
            ]
        );

        // 4. Kirim OTP ke email pengguna
        try {
            Mail::raw("Kode OTP Anda untuk reset password adalah: $otp", function ($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Kode Reset Password Terraserve');
            });

            return ResponseFormatter::success(null, 'OTP has been sent to your email.');

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Failed to send OTP email. Please try again later.', 500);
        }
    }

    /**
     * Handle reset password request (validates OTP).
     */
    public function reset(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'token' => 'required|numeric', // Token sekarang adalah OTP (angka)
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        // 2. Cari data token di database
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)->first();

        // 3. Cek jika token/OTP valid
        if (!$tokenData || !Hash::check($request->token, $tokenData->token)) {
            return ResponseFormatter::error(null, 'Invalid OTP.', 400);
        }

        // 4. Cek jika token sudah expired (misal: 15 menit)
        if (Carbon::parse($tokenData->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return ResponseFormatter::error(null, 'OTP has expired.', 400);
        }

        // 5. Update password user
        $user = User::where('email', $request->email)->first();
        $user->forceFill(['password' => Hash::make($request->password)])->save();

        // 6. Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return ResponseFormatter::success(null, 'Password has been reset successfully.');
    }
}
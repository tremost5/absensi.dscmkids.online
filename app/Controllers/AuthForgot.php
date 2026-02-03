<?php

namespace App\Controllers;

use App\Libraries\Whatsapp;

class AuthForgot extends BaseController
{
    public function index()
    {
        return view('auth/forgot_choice');
    }

    // RESET VIA EMAIL
    public function email()
    {
        $email = $this->request->getPost('email');

        $user = db_connect()->table('users')
            ->where('email',$email)->get()->getRowArray();

        if (!$user)
            return redirect()->back()->with('error','Email tidak ditemukan');

        $token = bin2hex(random_bytes(16));

        db_connect()->table('password_resets')->insert([
            'user_id'=>$user['id'],
            'token'=>$token,
            'expired_at'=>date('Y-m-d H:i:s',strtotime('+30 minutes'))
        ]);

        // kirim email (pakai Email CI4)
        service('email')
            ->setTo($email)
            ->setSubject('Reset Password')
            ->setMessage("Klik link berikut untuk reset:\n".
                base_url("reset-email/$token"))
            ->send();

        return redirect()->back()->with('success','Link reset dikirim ke email');
    }

    // RESET VIA WA (OTP)
    public function wa()
    {
        $hp = preg_replace('/[^0-9]/','',$this->request->getPost('no_hp'));

        $user = db_connect()->table('users')
            ->where('no_hp',$hp)->get()->getRowArray();

        if (!$user)
            return redirect()->back()->with('error','No HP tidak ditemukan');

        $otp = rand(100000,999999);

        db_connect()->table('password_otps')->insert([
            'user_id'=>$user['id'],
            'otp'=>$otp,
            'expired_at'=>date('Y-m-d H:i:s',strtotime('+5 minutes'))
        ]);

        Whatsapp::send(
            $hp,
            "🔐 RESET PASSWORD\nOTP: $otp\nBerlaku 5 menit\nDSCMKIDS SYSTEM"
        );

        session()->set('reset_user',$user['id']);
        return redirect()->to('/verify-otp');
    }
}

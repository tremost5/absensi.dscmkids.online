<?php

namespace App\Controllers;

use App\Libraries\Whatsapp;

class AuthOtp extends BaseController
{
    public function request()
    {
        return view('auth/request_otp');
    }

    public function send()
    {
        $nohp = $this->request->getPost('no_hp');

        $user = db_connect()->table('users')
            ->where('no_hp', $nohp)
            ->get()->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error','Nomor tidak terdaftar');
        }

        $otp = rand(100000,999999);
        $exp = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        db_connect()->table('password_otps')->insert([
            'user_id' => $user['id'],
            'otp' => $otp,
            'expired_at' => $exp,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Whatsapp::send(
            $nohp,
            "🔐 OTP RESET PASSWORD\nKode: $otp\nBerlaku 5 menit\nDSCMKIDS SYSTEM"
        );

        session()->set('reset_user', $user['id']);
        return redirect()->to('/verify-otp');
    }

    public function verify()
    {
        return view('auth/verify_otp');
    }

    public function check()
    {
        $otp = $this->request->getPost('otp');
        $uid = session()->get('reset_user');

        $row = db_connect()->table('password_otps')
            ->where('user_id',$uid)
            ->where('otp',$otp)
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->get()->getRowArray();

        if (!$row) {
            return redirect()->back()->with('error','OTP salah / expired');
        }

        session()->set('otp_verified', true);
        return redirect()->to('/reset-password-wa');
    }

    public function resetForm()
    {
        if (!session()->get('otp_verified')) {
            return redirect()->to('/login');
        }
        return view('auth/reset_password_wa');
    }

    public function resetSave()
    {
        $pass = password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        );

        db_connect()->table('users')
            ->where('id', session()->get('reset_user'))
            ->update(['password'=>$pass]);

        session()->destroy();
        return redirect()->to('/login')->with('success','Password berhasil direset');
    }
}

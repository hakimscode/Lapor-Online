<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserItem;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list_user()
    {
        $result = new UserCollection(User::where('jenis_user', 2)->get());
        return array("status" => true, "message" => "Berhasil", "result" => $result);
    }

    public function list_user_polisi()
    {
        return new UserCollection(User::where('jenis_user', 1)->get());
    }

    public function list_user_byid(User $userid)
    {
        $result = new UserItem($userid);
        return array("status" => true, "message" => "Berhasil", "result" => $result);
    }

    public function add_user(Request $request)
    {
        $status = false;
        $message = "";
        $result = array();

        $user = new User();
        $user->nama_user = $request->input('nama_user');
        $user->no_ktp = $request->input('no_ktp');
        $user->password = Hash::make($request->input('password'));
        $user->status = $request->input('status');
        $user->ktp_verified_at = $request->input('ktp_verified_at');
        $user->jenis_user = $request->input('jenis_user');

        if ($user->save()) {
            $status = true;
            $message = "Berhasil menambahkan data";
            $result = new UserItem($user);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    public function verifikasi_user($userid)
    {
        $status = false;
        $message = "";
        $result = array();

        $user = User::findOrFail($userid);

        $user->status = 1;
        $user->ktp_verified_at = now();

        if ($user->save()) {
            $status = true;
            $message = "Berhasil memverifikasi user";
            $result = new UserItem($user);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    public function login_user(Request $request)
    {
        $status = false;
        $message = "";
        $result = array();

        $user = User::where('no_ktp', $request->input('no_ktp'))->first();

        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                if ($user->status) {
                    $status = true;
                    $message = "Berhasil login";
                    $result = new UserItem($user);
                } else {
                    $message = "Akun anda belum diverifikasi";
                }
            } else {
                $message = "Password anda salah";
            }
        } else {
            $message = "Username tidak ditemukan";
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserItem;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function list_user()
    {
        $result = new UserCollection(User::where('jenis_user', 2)->orderBy('id', 'desc')->get());
        return array("status" => true, "message" => "Berhasil", "result" => $result);
    }

    public function list_user_polisi()
    {
        return new UserCollection(User::where('jenis_user', 1)->orderBy('id', 'desc')->get());
    }

    public function list_user_all()
    {
        $result = new UserCollection(User::orderBy('id', 'desc')->get());
        return array("status" => true, "message" => "Berhasil", "result" => $result);
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
        $user->pangkat = $request->input('pangkat');
        $user->jabatan = $request->input('jabatan');
        $user->instansi = $request->input('instansi');
        $user->alamat = $request->input('alamat');
        $user->no_hp = $request->input('no_hp');
        $user->email = $request->input('email');
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

    // Login dan mendapatkan token
    public function login_admin(Request $request)
    {
        $status = TRUE;
        $mesasge = "Berhasil login";
        $currentUser = array();

        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $status = FALSE;
                $mesasge = "Invalid username or password";
            } else {
                $currentUser = JWTAuth::user();
                Admin::where('id', $currentUser['id'])->update(["remember_token" => $token]);
            }
        } catch (JWTException $e) {
            $status = FALSE;
            $mesasge = "Something wrong in communicating with API or JWT";
        }

        return response()->json(array("status" => $status, "message" => $mesasge, "user" => $currentUser, "token" => $token));
    }

    public function getUserByToken($token)
    {
        $admin = Admin::where("remember_token", $token)->first();

        if ($admin) {
            return response()->json($admin);
        } else {
            return response()->json(array("id" => 0));
        }
    }

    public function destroy($id_user)
    {
        $status = false;
        $message = "";
        $result = array();

        $user = User::findOrFail($id_user);

        if ($user->delete()) {
            $status = true;
            $message = "Berhasil menghapus user";
            $result = new UserItem($user);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }
}

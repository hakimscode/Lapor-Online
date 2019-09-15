<?php

namespace App\Http\Controllers;

use App\Laporan;
use Illuminate\Http\Request;
use App\Http\Resources\LaporanCollection;
use Validator;
use App\Http\Resources\LaporanItem;

class LaporanController extends Controller
{

    private $path = '/img';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Laporan::join('users', 'users.id', '=', 'laporan.user_id', 'left')
            ->join('jenis_laporan', 'jenis_laporan.id', '=', 'laporan.jenis_laporan')
            ->select('laporan.*', 'jenis_laporan.jenis_laporan', 'users.nama_user')
            ->get();
        $result = new LaporanCollection($data);

        return array("status" => true, "message" => "Berhasil", "result" => $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = false;
        $message = "";
        $result = array();

        $laporan = $request->isMethod('put') ? Laporan::findOrFail($request->input('id')) : new Laporan();

        $max_upload = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
        $max_upload = str_replace('M', '', $max_upload);
        $max_upload = $max_upload * 1024;

        $validator = Validator::make($request->only(['gambar']), [
            'gambar' => 'required|max:' . $max_upload
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
        } else {
            ## Cek Direktori ##
            $path_root = "." . $this->path;
            if (!file_exists($path_root)) {
                mkdir($path_root, 0777);
            }
            ## END ##

            ## Gambar 1 ##
            $url_file = "";
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $eks_file = $file->getClientOriginalExtension();
                // $ukuran = $file->getSize();

                $nama_file_simpan = md5(time()) . "_1." . $eks_file;
                $url_file = url($this->path) . "/" . $nama_file_simpan;

                $file->move($path_root, $nama_file_simpan);
                ## End Gambar 1 ##
            }

            ## Gambar 2 ##
            $url_file2 = "";
            if ($request->hasFile('gambar2')) {
                $file2 = $request->file('gambar2');
                $eks_file2 = $file2->getClientOriginalExtension();
                // $ukuran = $file->getSize();

                $nama_file_simpan2 = md5(time()) . "_2." . $eks_file2;
                $url_file2 = url($this->path) . "/" . $nama_file_simpan2;

                $file2->move($path_root, $nama_file_simpan2);
            }
            ## End Gambar 2 ##

            ## Gambar 3 ##
            $url_file3 = "";
            if ($request->hasFile('gambar3')) {
                $file3 = $request->file('gambar3');
                $eks_file3 = $file3->getClientOriginalExtension();
                // $ukuran = $file->getSize();

                $nama_file_simpan3 = md5(time()) . "_3." . $eks_file3;
                $url_file3 = url($this->path) . "/" . $nama_file_simpan3;

                $file3->move($path_root, $nama_file_simpan3);
                ## End Gambar 3 ##
            }

            $laporan->jenis_laporan = $request->input('jenis_laporan');
            $laporan->user_id = $request->input('user_id');
            $laporan->tanggal_kejadian = $request->input('tanggal_kejadian');
            $laporan->tanggal_lapor = $request->input('tanggal_lapor');
            $laporan->judul_laporan = $request->input('judul_laporan');
            $laporan->deskripsi_laporan = $request->input('deskripsi_laporan');
            $laporan->alamat = $request->input('alamat');
            $laporan->latitude = $request->input('latitude');
            $laporan->longitude = $request->input('longitude');
            $laporan->gambar = $url_file;
            $laporan->gambar2 = $url_file2;
            $laporan->gambar3 = $url_file3;
            $laporan->verified = $request->input('verified');
            $laporan->status = $request->input('status');
            $laporan->public = 0;

            if ($laporan->save()) {
                $status = true;
                $message = "Berhasil menambah laporan";
                $result = new LaporanItem($laporan);
            }
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_laporan)
    {
        $data = Laporan::join('users', 'users.id', '=', 'laporan.user_id', 'left')
            ->join('jenis_laporan', 'jenis_laporan.id', '=', 'laporan.jenis_laporan')
            ->select('laporan.*', 'jenis_laporan.jenis_laporan', 'users.nama_user')
            ->where('laporan.id', $id_laporan)
            ->first();
        $result = new LaporanItem($data);
        return array("status" => true, "message" => "Berhasil", "result" => $result);
    }

    public function verifikasi_laporan($id_laporan)
    {
        $status = false;
        $message = "";
        $result = array();

        $laporan = Laporan::findOrFail($id_laporan);

        $laporan->verified = "1";
        $laporan->status = "1";

        if ($laporan->save()) {
            $status = true;
            $message = "Berhasil memverifikasi laporan";
            $result = new LaporanItem($laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    public function tolak_laporan($id_laporan)
    {
        $status = false;
        $message = "";
        $result = array();

        $laporan = Laporan::findOrFail($id_laporan);

        $laporan->status = "3";

        if ($laporan->save()) {
            $status = true;
            $message = "Berhasil menolak laporan";
            $result = new LaporanItem($laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_laporan)
    {
        $status = false;
        $message = "";
        $result = array();

        $laporan = Laporan::findOrFail($id_laporan);

        if ($laporan->delete()) {
            $status = true;
            $message = "Berhasil menghapus data laporan";
            $result = new LaporanItem($laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    public function update_status_laporan(Request $request)
    {
        $status = false;
        $message = "";
        $result = array();

        $laporan = Laporan::findOrFail($request->input('id'));

        $laporan->status = $request->input('status');

        if ($laporan->save()) {
            $status = true;
            $message = "Berhasil mengupdate status";
            $result = new LaporanItem($laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    public function update_publikasi(Request $request)
    {
        $status = false;
        $message = "";
        $result = array();

        $laporan = Laporan::findOrFail($request->input('id'));

        $laporan->public = $request->input('public');

        if ($laporan->save()) {
            $status = true;
            $message = "Berhasil mengupdate status publik laporan";
            $result = new LaporanItem($laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }
}

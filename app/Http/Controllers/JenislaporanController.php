<?php

namespace App\Http\Controllers;

use App\Jenislaporan;
use Illuminate\Http\Request;
use App\Http\Resources\JenislaporanCollection;
use App\Http\Resources\JenislaporanItem;

class JenislaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = new JenislaporanCollection(Jenislaporan::get());
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

        $jenis_laporan = $request->isMethod('put') ? Jenislaporan::findOrFail($request->input('id')) : new Jenislaporan();

        $jenis_laporan->id = $request->input('id');
        $jenis_laporan->jenis_laporan = $request->input('jenis_laporan');

        if ($jenis_laporan->save()) {
            $status = true;
            $message = "Berhasil menambah atau mengedit data";
            $result = new JenislaporanItem($jenis_laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jenislaporan  $jenislaporan
     * @return \Illuminate\Http\Response
     */
    public function show(Jenislaporan $id_jenislaporan)
    {
        $result = new JenislaporanItem($id_jenislaporan);
        return array("status" => true, "message" => "Berhasil", "result" => $result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jenislaporan  $jenislaporan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jenislaporan $jenislaporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jenislaporan  $jenislaporan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jenislaporan $jenislaporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jenislaporan  $jenislaporan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jenislaporan)
    {
        $status = false;
        $message = "";
        $result = array();

        $jenis_laporan = Jenislaporan::findOrFail($id_jenislaporan);

        if ($jenis_laporan->delete()) {
            $status = true;
            $message = "Berhasil menghapus data";
            $result = new JenislaporanItem($jenis_laporan);
        }

        return array("status" => $status, "message" => $message, "result" => $result);
    }
}

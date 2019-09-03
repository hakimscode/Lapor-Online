<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'jenis_laporan' => $this->jenis_laporan,
            'user_id' => $this->user_id,
            'nama_pelapor' => $this->nama_user,
            'tanggal_kejadian' => $this->tanggal_kejadian,
            'tanggal_lapor' => $this->tanggal_lapor,
            'judul_laporan' => $this->judul_laporan,
            'deskripsi_laporan' => $this->deskripsi_laporan,
            'alamat' => $this->alamat,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'gambar' => $this->gambar == null ? "" : $this->gambar,
            'gambar2' => $this->gambar2 == null ? "" : $this->gambar2,
            'gambar3' => $this->gambar3 == null ? "" : $this->gambar3,
            'verified' => $this->verified,
            'public' => $this->public,
            'status' => $this->stringStatus($this->status),
            'id_status' => $this->status
        ];
    }

    function stringStatus($status)
    {
        switch ($status) {
            case "0":
                return "Proses verifikasi laporan";
                break;
            case 1:
                return "Terverifikasi dan Sedang Dalam Proses Penugasan";
                break;
            case 2:
                return "Kasus Sudah Selesai";
                break;
            case 3:
                return "Laporan tidak diterima";
                break;
            default:
                return "Invalid status";
        }
    }
}

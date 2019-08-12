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
            'gambar' => $this->gambar,
            'verified' => $this->verified,
            'status' => $this->status
        ];
    }
}

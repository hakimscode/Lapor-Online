<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserItem extends JsonResource
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
            'nama_user' => $this->nama_user,
            'no_ktp' => $this->no_ktp,
            'pangkat' => $this->pangkat,
            'jabatan' => $this->jabatan,
            'instansi' => $this->instansi,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'status' => strval($this->status),
            'string_status' => $this->status == 0 ? "Inactive" : "Active",
            'ktp_verfied_at' => $this->ktp_verified_at == NULL ? "" : date_format($this->ktp_verified_at, 'd-M-Y H:i:s'),
            'jenis_user' => strval($this->jenis_user),
            'string_jenis_user' => $this->jenis_user == 1 ? "Polisi" : ($this->jenis_user == 2 ? "Sipil" : "")
        ];
    }
}

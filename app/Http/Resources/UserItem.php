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
            'status' => $this->status,
            'ktp_verfied_at' => $this->ktp_verified_at == NULL ? "" : date_format($this->ktp_verified_at, 'd-M-Y H:i:s'),
            'jenis_user' => $this->jenis_user
        ];
    }
}

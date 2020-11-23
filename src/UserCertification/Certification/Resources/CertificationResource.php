<?php

namespace MrwangTc\UserCertification\Certification\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CertificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'certification_id' => $this->id,
            'name'             => $this->name,
            'idcard'           => $this->id_card,
            'phone'            => $this->when(config('usercertification.open_phone_verified'), function(){
                return $this->phone;
            }),
            'front_card'       => $this->when(config('usercertification.open_card_verified') || $this->front_card, function(){
                return Storage::url($this->front_card);
            }),
            'back_card'       => $this->when(config('usercertification.open_card_verified') || $this->back_card, function(){
                return Storage::url($this->back_card);
            }),
            'created_at'       => (string)$this->created_at,
            'updated_at'       => (string)$this->updated_at,
        ];
    }
}
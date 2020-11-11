<?php

namespace MrwangTc\UserCertification\Certification\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'certification_id' => $this->id,
            'name'             => $this->name,
            'idcard'           => $this->idcard,
            'phone'            => $this->when(config('open_phone_verified'), function(){
                return $this->phone;
            }),
            'front_card'       => $this->when(config('open_card_verified'), function(){
                return $this->front_card;
            }),
            'back_card'       => $this->when(config('open_card_verified'), function(){
                return $this->back_card;
            }),
            'created_at'       => (string)$this->created_at,
            'updated_at'       => (string)$this->updated_at,
        ];
    }
}
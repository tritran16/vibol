<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccount extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if (!$this->resource) {
            return [];
        }
        $data['id'] = $this->id;

        $data['name'] = $this->name;
        $data['account'] = $this->account;
        $data['owner'] = $this->owner;
        $data['logo'] = $this->logo ? url($this->logo) : '';
        $data['pdf_file_kh'] = $this->pdf_file_kh?url($this->pdf_file_kh):'';
        $data['pdf_file_en'] = $this->pdf_file_en?url($this->pdf_file_en):'';
        return $data;

    }
}

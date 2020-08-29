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
        $data['pdf_file'] = $this->pdf_file?url($this->pdf_file):'';
        return $data;

    }
}

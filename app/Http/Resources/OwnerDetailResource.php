<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OwnerDetailResource extends Resource
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
            'number_of_outlet' => $this->number_of_outlet,
            'number_of_employee' => $this->number_of_employee
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'active' => !$this->trashed(),
            'detail' => $this->when($this->hasRole(Role::OWNER), new OwnerDetailResource($this->ownerDetail)),
            'shop' => $this->when($this->hasRole(Role::OWNER), new ShopResource($this->shop)),
            'outlet' => $this->when($this->hasRole(Role::CASHIER), new ShopOutletResource($this->outlets->first()))
        ];
    }
}

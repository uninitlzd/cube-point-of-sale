<?php

namespace App\Http\Controllers\Api;

trait AuthenticatedUser
{
    private $user;

    /**
     * AuthenticatedUser constructor.
     */
    public function __construct()
    {
        $this->user = auth('api')->user();
    }
}

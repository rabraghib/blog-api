<?php


namespace App\Controller;


use App\Entity\User;

class UserControllers
{
    public function __invoke(User $data)
    {
        return $data;
    }
}

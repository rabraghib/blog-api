<?php

namespace App\Controller;

use App\Entity\Blogs;

class BlogController
{

    public function __invoke(Blogs $data)
    {
        return $data;
    }

}

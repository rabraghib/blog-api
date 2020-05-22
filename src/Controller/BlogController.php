<?php

namespace App\Controller;

use App\Entity\Blogs;
use App\Repository\BlogsRepository;

class BlogController
{

    public function __invoke()
    {
        $blogRep = new BlogsRepository();
        $blogs = $blogRep->findBy(["is_publushed"=>true]);
        return $blogs;
    }

}

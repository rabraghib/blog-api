<?php

namespace App\DataFixtures;

use App\Entity\Blogs;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($u = 0; $u <10; $u++){
            $user = new User();
            $user->setEmail($faker->email)
                ->setUsername($faker->userName)
                ->setPassword($faker->password)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setMobile($faker->phoneNumber)
                ->setIntro($faker->text(500));
            $manager->persist($user);
            for ($b = 0;$b < random_int(1,8); $b++){
                $blog = new Blogs();
                $blog
                    ->setTitle($faker->text(80))
                    ->setIntro($faker->text(200))
                    ->setIsPublushed(random_int(1,10)%2 == 0)
                    ->setPoster($user)
                    ->setContent($faker->text(10000))
                    ->setMainImg("https://picsum.photos/id/".random_int(1,100)."/900/500");
                $manager->persist($blog);
            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

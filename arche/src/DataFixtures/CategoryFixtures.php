<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $categories = [
            'POLE Humanités',
            'Administration',
            'FISE Informatique',
            'Organisation de vos études / Continuité Pédagogique | DFP - Direction aux Formations et à la Pédagogie',
        ];

        foreach ($categories as $key => $label) {
            $category = new Category();
            $category->setLabel($label);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }

        $manager->flush();
    }
}

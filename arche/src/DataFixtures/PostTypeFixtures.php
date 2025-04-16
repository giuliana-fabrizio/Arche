<?php

namespace App\DataFixtures;

use App\Entity\PostType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostTypeFixtures extends Fixture
{
    public const TYPES = ['Important', 'Information'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TYPES as $index => $label) {
            $type = new PostType();
            $type->setLabel($label);
            $manager->persist($type);
            $this->addReference('post_type_' . $index, $type);
        }

        $manager->flush();
    }
}

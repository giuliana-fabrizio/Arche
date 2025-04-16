<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = [
            'Admin',
            'Admin & Professeur',
            'Professeur',
            'Étudiant',
        ];
        
        foreach ($roles as $key => $label) {
            $role = new Role();
            $role->setLabel($label);

            $manager->persist($role);
            $this->addReference('role_' . $key, $role);
        }

        $manager->flush();
    }
}

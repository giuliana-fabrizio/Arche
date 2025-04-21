<?php

namespace App\DataFixtures;

use App\Entity\Ue;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserUeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $relations = [
            ['user_ref' => 'user_1', 'ue_ref' => 'ue_0'],
            ['user_ref' => 'user_2', 'ue_ref' => 'ue_1'],
            ['user_ref' => 'user_3', 'ue_ref' => 'ue_2'],
        ];

        foreach ($relations as $rel) {
            $user = $this->getReference($rel['user_ref'], User::class);
            $ue = $this->getReference($rel['ue_ref'], Ue::class);

            $ue->addAssociatesUser($user);
            $user->addAssociatesUe($ue);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UeFixtures::class,
        ];
    }
}

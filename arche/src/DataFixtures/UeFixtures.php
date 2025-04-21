<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Ue;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ues = [
            [
                'code' => 'II21',
                'label' => 'Introduction à l’informatique',
                'category_ref' => 'category_2',
                'user_ref' => 'user_2',
            ],
            [
                'code' => 'HM50',
                'label' => 'Communication orale',
                'category_ref' => 'category_1',
                'user_ref' => 'user_2',
            ],
            [
                'code' => 'AM35',
                'label' => 'Procédures administratives',
                'category_ref' => 'category_1', // Administration
                'user_ref' => 'user_3',
            ],
        ];

        foreach ($ues as $key => $data) {
            $ue = new Ue();
            $ue->setCode($data['code']);
            $ue->setLabel($data['label']);
            $ue->setFkCategory($this->getReference($data['category_ref'], Category::class));
            $ue->setFkUser($this->getReference($data['user_ref'], User::class));

            $manager->persist($ue);
            $this->addReference('ue_' . $key, $ue);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}

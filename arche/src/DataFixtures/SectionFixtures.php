<?php

namespace App\DataFixtures;

use App\Entity\Section;
use App\Entity\Ue;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SectionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sections = [
            [
                'label' => 'Général',
                'ranking' => 1,
                'ue_ref' => 'ue_1',
                'user_ref' => 'user_2',
            ],
            [
                'label' => 'Organisation des TD',
                'ranking' => 2,
                'ue_ref' => 'ue_2',
                'user_ref' => 'user_2',
            ],
            [
                'label' => 'Organisation des TP',
                'ranking' => 1,
                'ue_ref' => 'ue_2',
                'user_ref' => 'user_3',
            ],
        ];

        foreach ($sections as $key => $data) {
            $section = new Section();
            $section->setLabel($data['label']);
            $section->setRanking($data['ranking']);
            $section->setFkUe($this->getReference($data['ue_ref'], Ue::class));
            $section->setFkUser($this->getReference($data['user_ref'], User::class));
            $manager->persist($section);
            $this->addReference('section_' . $key, $section);
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

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\PostType;
use App\Entity\User;
use App\Entity\Section;
use \DateTime;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $posts = [
            [
                'label' => 'Cours Intro',
                'description' => 'Contenu du cours d’introduction.',
                'datetime' => new DateTime('-3 days'),
                'filetype' => null,
                'filename' => null,
                'post_type_ref' => 'post_type_1',
                'user_ref' => 'user_1',
                'section_ref' => 'section_1',
            ],
            [
                'label' => 'TD1 Organisation',
                'description' => 'Premier TD sur l’organisation des TD.',
                'datetime' => new DateTime('-2 days'),
                'filetype' => 'zip',
                'filename' => 'td1_organisation.zip',
                'post_type_ref' => 'post_type_1',
                'user_ref' => 'user_2',
                'section_ref' => 'section_1',
            ],
            [
                'label' => 'Notes cours',
                'description' => 'Notes étudiant sur cours HUM1.',
                'datetime' => new DateTime('-1 day'),
                'filetype' => 'md',
                'filename' => 'notes_hum1.md',
                'post_type_ref' => 'post_type_1',
                'user_ref' => 'user_3',
                'section_ref' => 'section_1',
            ],
        ];

        foreach ($posts as $key => $data) {
            $post = new Post();
            $post->setLabel($data['label']);
            $post->setDescription($data['description']);
            $post->setDatetime($data['datetime']);

            $post->setFiletype($data['filetype']);
            $post->setFilename($data['filename']);

            $post->setFkPostType($this->getReference($data['post_type_ref'], PostType::class));
            $post->setFkUser($this->getReference($data['user_ref'], User::class));
            $post->setFkSection($this->getReference($data['section_ref'], Section::class));

            $manager->persist($post);
            $this->addReference('post_' . $key, $post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostTypeFixtures::class,
            UserFixtures::class,
            SectionFixtures::class,
        ];
    }
}

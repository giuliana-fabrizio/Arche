<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {}

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'lastname' => 'ADMIN',
                'firstname' => 'Admin',
                'email' => 'admin@utbm.fr',
                'role' => ['ROLE_ADMIN'],
            ],
            [
                'lastname' => 'MARTIN',
                'firstname' => 'Matin',
                'email' => 'matin.martin@utbm.fr',
                'role' => ['ROLE_ADMIN_PROFESSEUR'],
            ],
            [
                'lastname' => 'DUPONT',
                'firstname' => 'Pierre',
                'email' => 'pierre.dupont@utbm.fr',
                'role' => ['ROLE_PROFESSEUR'],
            ],
            [
                'lastname' => 'DURAND',
                'firstname' => 'Marion',
                'email' => 'marion.durand@utbm.fr',
                'role' => ['ROLE_ETUDIANT'],
            ],
        ];

        foreach ($users as $key => $data) {
            $user = new User();
            $user->setLastname($data['lastname']);
            $user->setFirstname($data['firstname']);
            $user->setEmail($data['email']);
            $user->setPhone('0600000000');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setRoles($data['role']);

            $errors = $this->validator->validate($user);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo $error->getMessage() . "\n";
                }
                return;
            }

            $manager->persist($user);
            $this->addReference('user_' . $key, $user);
        }

        $manager->flush();
    }
}

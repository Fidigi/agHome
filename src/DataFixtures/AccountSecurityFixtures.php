<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Service\TokenManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountSecurityFixtures extends Fixture
{
    private $passwordEncoder;
    private $tokenManager;
    
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder, 
        TokenManager $tokenManager
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenManager = $tokenManager;
    }
    
    public function load(ObjectManager $manager)
    {
        
        foreach ($this->getUserData() as [$firstname, $lastname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setUuid();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setActive(true);
            $user->setRoles($roles);
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            
            $manager->persist($user);
            $this->tokenManager->createTokenApiForUser($user);
        }
        
        $manager->flush();
    }
    
    private function getUserData(): array
    {
        return [
            // $userData = [$firstname, $lastname, $username, $password, $email, $roles];
            ['Admin', 'Admin', 'admin', 'pass', 'admin@example.com', ['ROLE_ADMIN']],
        ];
    }
    
    
}
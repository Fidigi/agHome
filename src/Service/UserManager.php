<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Common\HelperTrait\LoggerTrait;
use App\Entity\User;
use Faker\Factory;

class UserManager
{
    const USER_ROLE_USER = 'ROLE_USER';
    const USER_ROLE_MOD = 'ROLE_MOD';
    const USER_ROLE_ADMIN = 'ROLE_ADMIN';

    use LoggerTrait;
    
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @param ObjectManager $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        ObjectManager $entityManager, 
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     * @return User
     */
    public function register(User $user): User
    {
        $data= [];
        $data['firstname']=$user->getFirstname();
        $data['lastname']=$user->getLastname();
        $data['password']=$user->getPassword();
        $data['email']=$user->getEmail();
        $data['username']=$user->getUsername();
        return self::createFromArray($data);
    }

    /**
     * @param User $user
     * @param string $password
     * @return User
     */
    public function changePassword(User $user, string $plainPassword): User
    {
        $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        return $user;
    }
    
    /**
     * @param array $data
     * @return User
     */
    public function createFromArray(array $data): User
    {
        if (empty($data) || (
            empty($data['firstname']) &&
            empty($data['lastname']) &&
            empty($data['password']) &&
            empty($data['email']) &&
            empty($data['username'])
        )) {
            throw new MissingOptionsException();
        }
        $user = new User();
        $user->setUuid();
        
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        
        $password = $this->passwordEncoder->encodePassword($user, $data['password']);
        $user->setPassword($password);
        
        $user->setActive(false);
        $user->setRoles([self::USER_ROLE_USER]);
        $user->setCreatedAt(new \Datetime());
        
        self::save($user);
        return $user;
    }
    
    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): ?bool
    {
        $user->setUpdatedAt(new \Datetime());
        try {
            $this->entityManager->persist($user);
        } catch (ORMException $e) {
            self::logError($e->getMessage());
            return false;
        }
        $this->entityManager->flush();
        return true;
    }
    
}

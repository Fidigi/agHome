<?php
namespace App\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\UserManager;
use App\Entity\User;
use Faker\Factory;

class UserManagerTest extends TestCase
{
    /** @var User */
    private $user;

    /** @var MockObject|ObjectManager */
    private $entityManager;
    
    /** @var UserPasswordEncoderInterface|ObjectManager */
    private $passwordEncoder;
    
    /** @var UserManager */
    private $manager;
    
    private $faker;
    
    protected function setUp()
    {
        $this->user = $this->createMock(User::class);
        $this->entityManager = $this->createMock(ObjectManager::class);
        $this->passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->passwordEncoder->method('encodePassword')->willReturn('$2y$13$vNH4hSaJX08nnabbLZtxLunJn/3lnY1jZwy34sI82J.l74UBryl7m');
        $this->manager = new UserManager($this->entityManager,$this->passwordEncoder);
        
        $this->faker = Factory::create();
    }
    
    public function testRegister()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');
        
        $this->entityManager
        ->expects(self::once())
        ->method('flush');
        
        $user = new User();
        $user->setFirstname($this->faker->firstName());
        $user->setLastname($this->faker->lastName());
        $user->setEmail($this->faker->safeEmail());
        $user->setUsername('test');
        $user->setPassword('testtest');
        
        $user = $this->manager->register($user);
        
        self::assertInstanceOf(User::class, $user);
    }
    
    public function testCreateFromArrayWithEmptyData()
    {
        $this->expectException(MissingOptionsException::class);
        $user = new User();
        $this->manager->register($user);
    }

    public function testSaveFaillure()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');

        $this->entityManager->method('persist')->will($this->throwException(new ORMException('faillure')));
        
        self::assertEquals(false, $this->manager->save($this->user));
    }
}
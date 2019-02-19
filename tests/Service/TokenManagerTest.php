<?php
namespace App\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Service\TokenManager;
use App\Entity\Token;
use App\Entity\User;

class TokenManagerTest extends TestCase
{
    /** @var User */
    private $user;

    /** @var Token */
    private $token;

    /** @var MockObject|ObjectManager */
    private $entityManager;
    
    /** @var TokenGeneratorInterface|ObjectManager */
    private $tokenGenerator;
    
    /** @var TokenManager */
    private $manager;
    
    protected function setUp()
    {
        $this->user = $this->createMock(User::class);
        $this->token = $this->createMock(Token::class);
        $this->entityManager = $this->createMock(ObjectManager::class);
        $this->tokenGenerator = $this->createMock(TokenGeneratorInterface::class);
        $this->tokenGenerator->method('generateToken')->willReturn('token');
        $this->manager = new TokenManager($this->entityManager,$this->tokenGenerator);
    }
    
    public function testTokenActivation()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');
        
        $this->entityManager
        ->expects(self::once())
        ->method('flush');
        
        $token = $this->manager->createTokenActivationForUser($this->user);
        
        self::assertInstanceOf(Token::class, $token);
    }
    
    public function testTokenLost()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');
        
        $this->entityManager
        ->expects(self::once())
        ->method('flush');
        
        $token = $this->manager->createTokenLostForUser($this->user);
        
        self::assertInstanceOf(Token::class, $token);
    }
    
    public function testTokenApi()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');
        
        $this->entityManager
        ->expects(self::once())
        ->method('flush');
        
        $token = $this->manager->createTokenApiForUser($this->user);
        
        self::assertInstanceOf(Token::class, $token);
    }
    
    public function testCreateFromArrayWithEmptyData()
    {
        $this->expectException(MissingOptionsException::class);
        $data = [];
        $this->manager->createFromArray($data);
    }

    public function testDelete()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('remove');
        
        $this->entityManager
        ->expects(self::once())
        ->method('flush');
        
        $this->manager->delete($this->token);
    }

    public function testSaveFaillure()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');

        $this->entityManager->method('persist')->will($this->throwException(new ORMException('faillure')));
        
        self::assertEquals(false, $this->manager->save($this->token));
    }

    public function testDeleteFaillure()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('remove');

        $this->entityManager->method('remove')->will($this->throwException(new ORMException('faillure')));
        
        self::assertEquals(false, $this->manager->delete($this->token));
    }

    
}
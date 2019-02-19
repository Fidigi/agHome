<?php
namespace App\Tests\Service;

use Curl\Curl;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use App\Service\WheatherManager;
use App\Entity\Wheather;
use Faker\Factory;

class WheatherManagerTest extends TestCase
{
    /** @var Wheather */
    private $wheather;

    /** @var MockObject|ObjectManager */
    private $entityManager;

    /** @var Curl */
    protected $curl;
    
    /** @var WheatherManager */
    private $manager;
    
    private $faker;
    
    protected function setUp()
    {
        $this->wheather = $this->createMock(Wheather::class);
        $this->entityManager = $this->createMock(ObjectManager::class);
        $this->curl = $this->createMock(Curl::class);
        $this->manager = new WheatherManager($this->entityManager,$this->curl);

        $this->faker = Factory::create();
    }
    
    public function testCreateFromArray()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');
        
        $this->entityManager
        ->expects(self::once())
        ->method('flush');
        
        $wheather = $this->manager->createFromArray([
            'location' => ($this->faker->latitude(-90, 90).','.$this->faker->longitude(-180, 180)),
            'temperature' => $this->faker->randomFloat(1, -50, 50),
            'humidity' => $this->faker->randomFloat(1, 0, 100),
        ]);
        
        self::assertInstanceOf(Wheather::class, $wheather);
    }
    
    public function testCreateFromArrayWithEmptyData()
    {
        $this->expectException(MissingOptionsException::class);
        $this->manager->createFromArray([]);
    }

    public function testSaveFaillure()
    {
        $this->entityManager
        ->expects(self::once())
        ->method('persist');

        $this->entityManager->method('persist')->will($this->throwException(new ORMException('faillure')));
        
        self::assertEquals(false, $this->manager->save($this->wheather));
    }

    public function testCurlFaillure()
    {
        $this->curl->error = true;
        $this->curl->error_code = 500;
        
        self::assertEquals(false, $this->manager->generate());
    }
}
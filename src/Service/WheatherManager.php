<?php
namespace App\Service;

use \Curl\Curl;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use App\Common\HelperTrait\LoggerTrait;
use App\Entity\Wheather;
use Faker\Factory;

class WheatherManager
{
    use LoggerTrait;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(
        ObjectManager $entityManager,
        Curl $curl
    )
    {
        $this->entityManager = $entityManager;
        $this->curl = $curl;
    }
    
    /**
     * @return Wheather
     */
    public function generate(): Wheather
    {
        $location = '48.8568,2.3508';
        $data = [];
        $data['location'] = $location;
        
        $this->curl->setBasicAuthentication('studdy_laurent', 'KrGbWt7v4N2uT');
        $this->curl->get('https://api.meteomatics.com/now/t_2m:C,relative_humidity_2m:p/'.$location.'/json');
        if ($this->curl->error) {
            echo $this->curl->error_code;
        }
        else {
            $curlData = json_decode($this->curl->response)->data;
            foreach ($curlData as $paramData){
                if($paramData->parameter == 't_2m:C'){
                    $data['temperature'] = ($paramData->coordinates[0]->dates[0]->value);
                } 
                elseif ($paramData->parameter == 'relative_humidity_2m:p') {
                    $data['humidity'] = ($paramData->coordinates[0]->dates[0]->value);
                }
            }
        }
        
        $wheather = self::createFromArray($data);
        return $wheather;
    }
    
    /**
     * @return Wheather
     */
    public function generateFake(): Wheather
    {
        $this->faker = Factory::create();
        
        $data= [
            'location' => '48.8568,2.3508',
            'temperature' => $this->faker->randomFloat(1, -50, 50),
            'humidity' => $this->faker->randomFloat(1, 0, 100),
        ];
        
        $wheather = self::createFromArray($data);
        return $wheather;
    }
    
    /**
     * @param array $data
     * @return Wheather
     */
    public function createFromArray(array $data): Wheather
    {
        if (empty($data) || (
            empty($data['location']) && 
            empty($data['temperature']) && 
            empty($data['humidity'])
        )) {
            throw new MissingOptionsException();
        }
        $wheather = new Wheather();
        
        $wheather->setLocation($data['location']);
        $wheather->setTemperature($data['temperature']);
        $wheather->setHumidity($data['humidity']);
        $wheather->setCreatedAt(new \DateTime());
        
        self::save($wheather);
        return $wheather;
    }
    
    /**
     * @param Wheather $wheather
     * @return bool
     */
    public function save(Wheather $wheather): ?bool
    {
        try {
            $this->entityManager->persist($wheather);
        } catch (ORMException $e) {
            self::logError($e->getMessage());
            return false;
        }
        $this->entityManager->flush();
        return true;
    }
    
}

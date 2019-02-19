<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\EntityTrait\EntityCreatedAtTrait;
use App\Common\EntityTrait\EntityIdTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WheatherRepository")
 */
class Wheather
{
    use EntityIdTrait;
    use EntityCreatedAtTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="float")
     */
    private $temperature;

    /**
     * @ORM\Column(type="float")
     */
    private $humidity;

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }
}

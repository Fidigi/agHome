<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

trait EntityActivableTrait
{
    /**
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    protected $isActive = false;
    
    public function isActive(): ?bool
    {
        return $this->isActive;
    }
    
    public function setActive(bool $bool): self
    {
        $this->isActive = $bool;
        
        return $this;
    }
}


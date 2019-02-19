<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

trait EntityDisablableTrait
{
    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    protected $isEnabled = true;
    
    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }
    
    public function setEnabled(bool $bool): self
    {
        $this->isEnabled = $bool;
        
        return $this;
    }
}


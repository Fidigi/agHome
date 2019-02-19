<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

trait EntityLockableTrait
{
    /**
     * @ORM\Column(name="failures", type="integer", nullable=true)
     */
    protected $failures = 0;
    
    /**
     * @ORM\Column(name="locked_until", type="integer", nullable=true)
     */
    protected $lockedUntil;
    
    public function isLocked(): bool
    {
        return $this->lockedUntil === null || $this->lockedUntil !== 0 && $this->lockedUntil <= time();
    }
    
    public function getFailures(): int
    {
        return $this->failures;
    }
    
    public function incFailures(): self
    {
        ++$this->failures;
        return $this;
    }
    
    public function lock(\DateTimeInterface $time = null): self
    {
        $this->failures = null;
        $this->lockedUntil  = $time === null ? 0 : $time->getTimestamp();
        
        return $this;
    }
    
    public function unlock(): self
    {
        $this->failures = null;
        $this->lockedUntil  = null;
        return $this;
    }
}


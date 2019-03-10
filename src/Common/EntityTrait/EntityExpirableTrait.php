<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

trait EntityExpirableTrait
{
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $expiredAt;

    public function setExpiredAt(\DateTimeInterface $expiredAt = null): self
    {
        $this->expiredAt  = $expiredAt === null ? 0 : $expiredAt->getTimestamp();

        return $this;
    }
    
    public function isExpired(): bool
    {
        return ($this->expiredAt === 0 || $this->expiredAt < time());
    }
}
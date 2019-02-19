<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;

trait EntityIdTrait
{
    /**
     * The unique auto incremented primary key.
     *
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}

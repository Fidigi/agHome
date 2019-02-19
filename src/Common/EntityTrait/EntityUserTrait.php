<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityUserTrait
{
    use EntityIdTrait;
    use EntityUuidTrait;
    use EntityPersonBasicTrait;
	use EntityTimestampableTrait;
	use EntityActivableTrait;
	use EntityLockableTrait;
	use EntitySoftDeletableTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
	protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
	protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=255, minMessage="Password too short")
     */
	protected $password;

    /**
     * @ORM\Column(type="array")
     */
	protected $roles = [];

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Array
     */
    public function getRoles(): ?array
    {
        $roles = $this->roles;
        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    
    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials(): void
    {}
    
    /**
     * Retour le salt qui a servi à coder le mot de passe
     */
    public function getSalt(): ?string
    {
        return null;
    }

    // serialize and unserialize must be updated - see below
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->isActive,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->isActive,
        ) = unserialize($serialized);
    }
}
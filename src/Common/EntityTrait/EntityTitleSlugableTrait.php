<?php
namespace App\Common\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityTitleSlugableTrait
{
    /**
     * @var string|null
     *
     * @ORM\Column(length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    protected $title;

    /**
     * @var string|null
     *
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    public function __toString()
    {
        return $this->title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        $this->setSlug($title);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    private function setSlug(?string $slug): self
    {
        $this->slug = self::slugify($slug);

        return $this;
    }

    protected static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}
<?php

namespace App\Entity;

use App\Repository\AdTagsRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @ORM\Table(name="ad_tag")
 * @ORM\Entity(repositoryClass=AdTagsRepository::class)
 */
class AdTags
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", unique=true, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="tag_name", type="string", length=255, unique=true, nullable=false)
     */
    private $name;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}

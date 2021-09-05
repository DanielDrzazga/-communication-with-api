<?php

namespace App\Entity;

use App\Repository\AdUrlsRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Nonstandard\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="Ad_url")
 * @ORM\Entity(repositoryClass=AdUrlsRepository::class)
 */
class AdUrls
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", unique=true, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="url_address", type="string", length=255, unique=true, nullable=false)
     */
    private $address;

    public function __construct(string $url)
    {
        $this->id = Uuid::uuid4();
        $this->address = $url;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

}

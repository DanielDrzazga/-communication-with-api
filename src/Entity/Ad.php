<?php

namespace App\Entity;

use App\Repository\AdRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @ORM\Table(name="ad")
 * @ORM\Entity(repositoryClass=AdRepository::class)
 */
class Ad
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", unique=true, nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="AdUrls")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="AdTags")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    private $tag;

    /**
     * @ORM\Column(name="currency", type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @ORM\Column(name="date", type="datetime", length=255, nullable=false)
     */
    private $date;

    /**
     * @ORM\Column(name="estimated_revenue", type="decimal", precision=10, scale=2, nullable=false,
     *     options={"default" : 0.00})
     */
    private $estimatedRevenue;

    /**
     * @ORM\Column(name="ad_impressions", type="integer", nullable=false, options={"default" : 0})
     */
    private $adImpressions;

    /**
     * @ORM\Column(name="ad_ecmp", type="integer", nullable=false, options={"default" : 0})
     */
    private $adEcpm;

    /**
     * @ORM\Column(name="clicks", type="integer", nullable=false, options={"default" : 0})
     */
    private $clicks;

    /**
     * @ORM\Column(name="ad_ctr", type="decimal", precision=10, scale=2, nullable=false,
     *     options={"default" : 0.00})
     */
    private $adCTR;


    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($tag): void
    {
        $this->tag = $tag;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getEstimatedRevenue()
    {
        return $this->estimatedRevenue;
    }

    public function setEstimatedRevenue($estimatedRevenue): void
    {
        $this->estimatedRevenue = $estimatedRevenue;
    }

    public function getAdImpressions()
    {
        return $this->adImpressions;
    }

    public function setAdImpressions($adImpressions): void
    {
        $this->adImpressions = $adImpressions;
    }

    public function getAdEcpm()
    {
        return $this->adEcpm;
    }

    public function setAdEcpm($adEcpm): void
    {
        $this->adEcpm = $adEcpm;
    }

    public function getClicks()
    {
        return $this->clicks;
    }

    public function setClicks($clicks): void
    {
        $this->clicks = $clicks;
    }

    public function getAdCTR()
    {
        return $this->adCTR;
    }

    public function setAdCTR($adCTR): void
    {
        $this->adCTR = $adCTR;
    }

}
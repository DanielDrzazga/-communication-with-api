<?php

namespace App\Repository;

use App\Entity\Ad;
use App\Entity\AdTags;
use App\Entity\AdUrls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    private $adUrlsRepository;
    private $adTagsRepository;

    public function __construct(ManagerRegistry $registry, AdUrlsRepository $adUrlsRepository, AdTagsRepository $adTagsRepository)
    {
        parent::__construct($registry, Ad::class);
        $this->adUrlsRepository = $adUrlsRepository;
        $this->adTagsRepository = $adTagsRepository;
    }

    public function saveOrUpdate(Ad $ad)
    {
        $this->adUrlsRepository->saveOrUpdate($ad->getUrl());
        $this->adTagsRepository->saveOrUpdate($ad->getTag());

        $this->getEntityManager()->persist($ad);
        $this->getEntityManager()->flush();
    }

    public function findAllAd()
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->select('a.id',
                'u.address AS url',
                't.name AS tag',
                "a.currency", "a.estimatedRevenue",
                "a.adImpressions", "a.adEcpm", "a.clicks", "a.adCTR",
                "a.date", "a.createdAt")
            ->leftJoin(AdUrls::class, 'u', Join::WITH, 'u.id = a.url')
            ->leftJoin(AdTags::class, 't', Join::WITH, 't.id = a.tag')
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function removeAd(Ad $ad):void
    {
        $this->getEntityManager()->remove($ad);
        $this->getEntityManager()->flush();
    }


}

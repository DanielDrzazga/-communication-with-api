<?php

namespace App\Repository;

use App\Entity\AdUrls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdUrls|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdUrls|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdUrls[]    findAll()
 * @method AdUrls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdUrlsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdUrls::class);
    }

    public function saveOrUpdate($getUrl)
    {
        $this->getEntityManager()->persist($getUrl);
        $this->getEntityManager()->flush();
    }

    public function findByUrlAddress(string $address):array
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->where('u.address = :address')
            ->setParameter('address', $address)
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }
}

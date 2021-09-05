<?php

namespace App\Repository;

use App\Entity\AdTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdTags|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdTags|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdTags[]    findAll()
 * @method AdTags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdTags::class);
    }

    public function saveOrUpdate(AdTags $adTags)
    {
        $this->getEntityManager()->persist($adTags);
        $this->getEntityManager()->flush();
    }

    public function findByUrlAddress($name):array
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.name = :name')
            ->setParameter('name', $name)
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }
}

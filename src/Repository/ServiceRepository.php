<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function getUniqueCategories(): array
    {
        $qb = $this->createQueryBuilder('s')
            ->select('DISTINCT s.category')
            ->orderBy('s.category', 'ASC');

        $result = $qb->getQuery()->getScalarResult();
        return array_column($result, 'category');
    }
    /**
     * @return Service[]
     */
    public function findActiveServices(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.deleted = :deleted')
            ->setParameter('deleted', false)
            ->getQuery()
            ->getResult();
    }
}

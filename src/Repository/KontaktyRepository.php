<?php

namespace App\Repository;

use App\Entity\Kontakty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class KontaktyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Kontakty::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('k')
            ->where('k.something = :value')->setParameter('value', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}

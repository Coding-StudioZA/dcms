<?php

namespace App\Repository;

use App\Entity\Faktury;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FakturyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Faktury::class);
    }

    public function unpaidInvoices($id){
        return $this->createQueryBuilder('invoice')
            ->where('invoice.stan != 3')
            ->andWhere('invoice.nr_kontrahenta = :id')->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Boleto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Boleto>
 *
 * @method Boleto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boleto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boleto[]    findAll()
 * @method Boleto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoletoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boleto::class);
    }

//    /**
//     * @return Boleto[] Returns an array of Boleto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Boleto
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
        // public function findNumeroUnico($sorteo,$numero)
        // {
        //     return $this->createQueryBuilder('b')
        //     ->andWhere('b.numero = :num AND b.sorteo = :sor')
        //     ->setParameter('sor', $sorteo)
        //     ->setParameter('num', $numero)
        //     ->getQuery()
        //     ->getOneOrNullResult()
        //     ;
        // }

        public function findCantidadVendida($sorteo)
        {
            return $this->createQueryBuilder('b')
            ->select('COUNT(b.id) as cantidadVendida') 
            ->andWhere('b.sorteo = :sor')
            ->setParameter('sor', $sorteo)
            ->getQuery()
            ->getSingleScalarResult()
            ;
        }

        public function findBoletoGanador($sorteo)
        {
            $boletos = $this->createQueryBuilder('b')
            ->andWhere('b.sorteo = :sorteo')
            ->setParameter('sorteo', $sorteo)
            ->getQuery()
            ->getResult();

            shuffle($boletos);

            return count($boletos) > 0 ? $boletos[0] : null;
        }
}

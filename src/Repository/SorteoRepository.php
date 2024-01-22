<?php

namespace App\Repository;

use App\Entity\Sorteo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sorteo>
 *
 * @method Sorteo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorteo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorteo[]    findAll()
 * @method Sorteo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SorteoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorteo::class);
    }

//    /**
//     * @return Sorteo[] Returns an array of Sorteo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sorteo
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
        // public function findSorteosDelUsuarioActual($usuario)
        // {
        //     $fechaActual = new \DateTime('now');
        //     $qb = $this->createQueryBuilder('s');

        //     $resultados = $qb->select('s')
        //     ->join('s.boletos', 'b')
        //     ->where('b.propietario = :usuario')
        //     ->andWhere('s.fechaFIN < :fechaActual')
        //     ->groupBy('s.id')
        //     ->setParameter('usuario', $usuario)
        //     ->setParameter('fechaActual', $fechaActual)
        //     ->getQuery()
        //     ->getResult();

        //     return $resultados;
        // }

        public function findSorteosGanadosPorUsuario($usuario)
    {
        $fechaActual = new \DateTime('now');

        $qb = $this->createQueryBuilder('s');

        $resultados = $qb->select('s')
            ->join('s.boletos', 'b')
            ->where('b.propietario = :usuario')
            ->andWhere('s.ganador = :usuario') // Ajusta la condición para la relación con el ganador
            ->andWhere('s.fechaFIN < :fechaActual')
            ->groupBy('s.id')
            ->setParameter('usuario', $usuario)
            ->setParameter('fechaActual', $fechaActual)
            ->getQuery()
            ->getResult();

        return $resultados;
    }

    public function findSorteosCerrados()
    {
        $fechaActual = new \DateTime('now');

        return $this->createQueryBuilder('s')
            ->andWhere('s.fechaFIN < :fechaActual')
            ->setParameter('fechaActual', $fechaActual)
            ->getQuery()
            ->getResult();
    }
}
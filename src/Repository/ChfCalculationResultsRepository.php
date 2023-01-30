<?php

namespace App\Repository;

use App\Entity\ChfCalculationResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChfCalculationResults>
 *
 * @method ChfCalculationResults|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChfCalculationResults|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChfCalculationResults[]    findAll()
 * @method ChfCalculationResults[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChfCalculationResultsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChfCalculationResults::class);
    }

    public function save(ChfCalculationResults $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChfCalculationResults $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ChfCalculationResults[] Returns an array of ChfCalculationResults objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ChfCalculationResults
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\PlnCalculationResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlnCalculationResults>
 *
 * @method PlnCalculationResults|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlnCalculationResults|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlnCalculationResults[]    findAll()
 * @method PlnCalculationResults[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlnCalculationResultsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlnCalculationResults::class);
    }

    public function save(PlnCalculationResults $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlnCalculationResults $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PlnCalculationResults[] Returns an array of PlnCalculationResults objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlnCalculationResults
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

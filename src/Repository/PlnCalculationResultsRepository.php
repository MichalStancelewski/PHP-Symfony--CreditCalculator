<?php

namespace App\Repository;

use App\Entity\PlnCalculationResults;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
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

    public function findOrFail(int $id): PlnCalculationResults
    {
        $plnCalculationResults = $this->find($id);

        if(!$plnCalculationResults) {
            $exceptionData = new ServiceExceptionData(404, 'Calculation Not Found');
            throw new ServiceException($exceptionData);
        }

        return $plnCalculationResults;
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

}

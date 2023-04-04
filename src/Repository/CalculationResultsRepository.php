<?php

namespace App\Repository;

use App\Entity\CalculationResults;
use App\Entity\PlnCalculationResults;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalculationResults>
 *
 * @method CalculationResults|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalculationResults|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalculationResults[]    findAll()
 * @method CalculationResults[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculationResultsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalculationResults::class);
    }

    public function findOrFail(int $id): CalculationResults
    {
        $calculationResults = $this->find($id);

        if(!$calculationResults) {
            $exceptionData = new ServiceExceptionData(404, 'Calculation Not Found');
            throw new ServiceException($exceptionData);
        }

        return $calculationResults;
    }

    public function save(CalculationResults $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CalculationResults $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}

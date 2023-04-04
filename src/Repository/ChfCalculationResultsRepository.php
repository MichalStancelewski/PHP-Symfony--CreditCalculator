<?php

namespace App\Repository;

use App\Entity\ChfCalculationResults;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
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

    public function findOrFail(int $id): ChfCalculationResults
    {
        $chfCalculationResults = $this->find($id);

        if(!$chfCalculationResults) {
            $exceptionData = new ServiceExceptionData(404, 'Calculation Not Found');
            throw new ServiceException($exceptionData);
        }

        return $chfCalculationResults;
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

}

<?php

namespace App\Repository;

use App\Entity\CreditData;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditData>
 *
 * @method CreditData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditData[]    findAll()
 * @method CreditData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditData::class);
    }

    public function findOrFail(int $id): CreditData
    {
        $result = $this->find($id);
        if (!$result) {
            $exceptionData = new ServiceExceptionData(404, 'Calculation Not Found');
            throw new ServiceException($exceptionData);
        }

        return $result;
    }

    public function save(CreditData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CreditData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CreditData[]
     */
    public function findByCurrency($value): array
    {
        $result = $this->createQueryBuilder('p')
            ->andWhere('p.currency = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();

        if (!$result) {
            $exceptionData = new ServiceExceptionData(404, 'No Calculation Found');
            throw new ServiceException($exceptionData);
        }

        return $result;
    }

}

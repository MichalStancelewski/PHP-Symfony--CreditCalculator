<?php

namespace App\Repository;

use App\Entity\AuthKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuthKey>
 *
 * @method AuthKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthKey[]    findAll()
 * @method AuthKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthKey::class);
    }

}

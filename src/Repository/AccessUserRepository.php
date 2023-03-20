<?php

namespace App\Repository;

use App\Entity\AccessUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccessUser>
 *
 * @method AccessUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccessUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccessUser[]    findAll()
 * @method AccessUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccessUser::class);
    }

    public function save(AccessUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccessUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

<?php

namespace App\Repository;

use App\Entity\PersonalLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonalLink>
 *
 * @method PersonalLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalLink[]    findAll()
 * @method PersonalLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalLink::class);
    }

    public function save(PersonalLink $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PersonalLink $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
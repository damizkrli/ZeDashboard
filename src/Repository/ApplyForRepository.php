<?php

namespace App\Repository;

use App\Entity\ApplyFor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplyFor>
 *
 * @method ApplyFor|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplyFor|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplyFor[]    findAll()
 * @method ApplyFor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplyForRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplyFor::class);
    }

    public function add(ApplyFor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplyFor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findApplyForPaginated(int $page, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('App\Entity\ApplyFor', 'a')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
        ;

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;

        return $result;
    }
}

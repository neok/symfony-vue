<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Model\RequestModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function searchByRequestModel(RequestModel $requestModel)
    {
        $qb = $this->createQueryBuilder('m');

        if ($requestModel->getTitle()) {
            $qb->andWhere('m.title LIKE :title');
            $qb->setParameter('title', '%'.$requestModel->getTitle().'%');
        }

        if ($requestModel->getGenre()) {
            $qb->andWhere('m.genre LIKE :genre');
            $qb->setParameter('genre', '%'.$requestModel->getGenre().'%');
        }

        $start = $requestModel->getWeekStart();
        $end   = $requestModel->getWeekEnd();

        if ($start && $end) {
            $qb->join('m.showtimes', 's');
            $qb->andWhere('s.showtime BETWEEN :start AND :end');
            $qb->setParameter('start', $start);
            $qb->setParameter('end', $end);
            $qb->groupBy('m.id');
        }

        return $qb->getQuery()->getResult();
    }
}

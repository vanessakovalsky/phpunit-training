<?php

namespace App\Repository;

use App\Entity\Pronostic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pronostic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pronostic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pronostic[]    findAll()
 * @method Pronostic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PronosticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pronostic::class);
    }

    public function getPronoByUserGroupedByMatch($user_id){
      $query = $this->createQueryBuilder('p')
                    ->andWhere('p.id_user = :user_id')
                    ->innerJoin('p.id_game', 'games')
                    ->addSelect('games')
                    ->orderBy('games.id')
                    ->setParameter('user_id',$user_id);
      return $query->getQuery()->getResult();
    }

}

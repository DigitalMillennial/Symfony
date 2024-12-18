<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artist>
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }
    public function getSomeArtists($name)
    {
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT a
         FROM App\Entity\Artist a
         WHERE a.name LIKE :name'
    )->setParameter('name', '%'.$name.'%');

    return $query->getResult();
    }
    public function getSomeArtistsWithQueryBuilder($name)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->andWhere('a.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return Artist[] Returns an array of Artist objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Artist
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

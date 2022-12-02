<?php

namespace App\Repository;

use App\Entity\Campagne;
use App\Entity\PromesseDon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromesseDon>
 *
 * @method PromesseDon|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromesseDon|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromesseDon[]    findAll()
 * @method PromesseDon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromesseDonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromesseDon::class);
    }

    public function save(PromesseDon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PromesseDon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByCampagne(string $campagneId){
        $manager = $this->getEntityManager();
        $query = $manager->createQuery(
            'SELECT d, c
            FROM App\Entity\PromesseDon d
            INNER JOIN d.campagne c
            WHERE c.id = :id')->setParameter('id', $campagneId);
        return $query->getResult();

    }

//    /**
//     * @return PromesseDon[] Returns an array of PromesseDon objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PromesseDon
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

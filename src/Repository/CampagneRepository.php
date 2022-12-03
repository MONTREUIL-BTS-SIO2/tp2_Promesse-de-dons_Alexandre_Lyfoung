<?php

namespace App\Repository;

use App\Entity\Campagne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campagne>
 *
 * @method Campagne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campagne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campagne[]    findAll()
 * @method Campagne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampagneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campagne::class);
    }

    public function save(Campagne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Campagne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMostDon()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c.nom, Count(d.campagne) as NbDon
            FROM App\Entity\PromesseDon d
            INNER JOIN d.campagne c
            GROUP BY c.nom
            ORDER BY NbDon DESC');

        $result = $query->execute();

        return $result;
    }

    public function findDonEnAttenteByCampagneID(String $id)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT Sum(d.montantDon) as MontantDonAttente
            FROM App\Entity\PromesseDon d
            INNER JOIN d.campagne c
            WHERE c.id = :id AND d.dateHonore IS Null')->setParameter('id', $id);

        return $query->execute();
    }

    public function findDonPayeByCampagneID(String $id)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT Sum(d.montantDon) as MontantPaye
            FROM App\Entity\PromesseDon d
            INNER JOIN d.campagne c
            WHERE c.id = :id AND d.dateHonore IS NOT Null')->setParameter('id', $id);

        return $query->execute();
    }

    public function findMostDonRecolte()
    {
        $query = $this->getEntityManager()->createQuery('
        SELECT c.nom, SUM(d.montantDon) as Somme
        FROM App\Entity\PromesseDon d
        INNER JOIN d.campagne c
        WHERE d.dateHonore IS NOT NULL
        GROUP BY c.nom
        ORDER by Somme DESC
        ');

        $result = $query->execute();
        return $result;
    }
    public function findMostDonRecolteByCampagneId(String $id)
    {
        $query = $this->getEntityManager()->createQuery('
        SELECT SUM(d.montantDon) as Somme
        FROM App\Entity\PromesseDon d
        INNER JOIN d.campagne c
        WHERE d.dateHonore IS NOT NULL AND c.id = :id
        ')->setParameter('id', $id);
        $result = $query->execute();

        return $result;
    }
    public function findMostDonPromisByCampagneId(String $id)
    {
        $query = $this->getEntityManager()->createQuery('
        SELECT SUM(d.montantDon) as Somme
        FROM App\Entity\PromesseDon d
        INNER JOIN d.campagne c
        WHERE c.id = :id
        ')->setParameter('id', $id);
        $result = $query->execute();
        //dd($result);
        return $result;
    }

    public function findNumberDonByCampagne()
    {
        $query = $this->getEntityManager()->createQuery('
        SELECT c.nom, COUNT(d.montantDon) as Somme
        FROM App\Entity\PromesseDon d
        INNER JOIN d.campagne c 
        GROUP BY c.nom
        ');

        return $query->execute();
    }

    public function findNumberDonHonoreByCamapgne()
    {
        $query = $this->getEntityManager()->createQuery('
        SELECT c.nom, COUNT(d.montantDon) as Somme
        FROM App\Entity\PromesseDon d
        INNER JOIN d.campagne c
        WHERE d.dateHonore IS NOT Null
        GROUP BY c.nom
        ');

        return $query->execute();
    }

    public function findNumberDonHonoreByCamapgneId(String $id)
    {
        $query = $this->getEntityManager()->createQuery('
        SELECT c.nom, COUNT(d.montantDon) as Somme
        FROM App\Entity\PromesseDon d
        INNER JOIN d.campagne c
        WHERE d.dateHonore IS NOT Null
        GROUP BY c.nom
        ');

        return $query->execute();
    }

//    /**
//     * @return Campagne[] Returns an array of Campagne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Campagne
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

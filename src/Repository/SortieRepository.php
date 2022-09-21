<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\User;
use App\Models\Filtres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function listeSortie(Filtres $filtre, User $user): ?array
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $expr = $queryBuilder->expr();

        $queryBuilder->join('s.etat', 'e')
                     ->addSelect('e')
                     ->where($expr->neq('e.libelle',':libelle'))
                     ->setParameter('libelle','Historisée')
                     ->andWhere('s.campus = :campus')
                     ->setParameter('campus',$filtre->campus);


        if(!empty($filtre->nom))
        {
            $queryBuilder->andWhere('s.nom LIKE :motCle')
                         ->setParameter('motCle','%'.$filtre->nom.'%');
        }


        if(!empty($filtre->dateDebut))
        {
            $queryBuilder->andWhere('s.dateHeureDebut >= :dateDebut')
                         ->setParameter('dateDebut',$filtre->dateDebut);
        }



        if($filtre->sortiesOrganisateur)
       {
            $queryBuilder->andWhere('s.organisateur = :organisateur')
                        ->setParameter('organisateur',$user);
        }


        $query = $queryBuilder->getQuery();
        $results = $query->getResult();
        return $results;
    }
    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }




//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUserByMail($email){
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUserSignByYear(int $year):array
    {
        $countArray = [];
        for ($i = 1;$i<=12;$i++)
        {
            $startDate = $year.'-'.$i.'-1';
            if ($i === 12){
                $endDate = ($year+1).'-1'.'-1';
            }else {
                $endDate = $year.'-'.($i+1).'-1';
            }

            $count = $this->createQueryBuilder('u');
            $count->select('COUNT(u.id)');
            $count->where('u.created_at >= :startDate and u.created_at < :endDate');
            $count ->setParameters([
                    'startDate' => $startDate,
                    'endDate' => $endDate
                ]);
            ;
            $countArray[] = $count->getQuery()->getSingleResult();
        }
        return $countArray;
    }

    public function countUser()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->getQuery()
            ->getResult();
    }
}

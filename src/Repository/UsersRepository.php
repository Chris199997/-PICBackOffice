<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
       public function countById(string $nom,string $password):array
    {   
        $users = new Users();
        $users->setNom($nom);
        $users->setPassword($password);
        $conn = $this->getEntityManager()->getConnection();

        $sql = ' SELECT COUNT(*)as nbr from users AS P 
        WHERE P.nom =:nom 
        AND P.password =:passwords
        ';
       
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':nom',$users->getNom());
      $stmt->bindValue(':passwords',$users->getPassword());
      $stmt->execute();
      $result =$stmt->fetchAll();
      $stmt->closeCursor();
      $conn->close();
      return $result;
    }


    public function create(string $nom,string $password)
    {   
        $users = new Users();
        $users->setNom($nom);
        $users->setPassword($password);
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT INTO users  ( `nom`, `password`) VALUES (:nom ,:passwords)';
       
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':nom',$users->getNom());
      $stmt->bindValue(':passwords',$users->getPassword());
      $stmt->execute();
      $stmt->closeCursor();
      $conn->close();
    
    }
    public function update(string $nom,string $password,int $id)
    {   
        $users = new Users();
        $users->setNom($nom);
        $users->setPassword($password);
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE users SET nom = :nom ,password=:passwords WHERE id =:id';
       
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':nom',$users->getNom());
      $stmt->bindValue(':passwords',$users->getPassword());
      $stmt->bindValue(':id',$id);
      $stmt->execute();
      $stmt->closeCursor();
      $conn->close();
      
    }
    public function delete(int $id)
    {   
       
      $conn = $this->getEntityManager()->getConnection();
      $sql = 'DELETE FROM users WHERE id =:id';
       
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':id',$id);
      $stmt->execute();
      $stmt->closeCursor();
      $conn->close();
      
    }
    public function findAll():array
    {   
       
      $conn = $this->getEntityManager()->getConnection();
      $sql = 'SELECT * FROM users ';
       
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result =$stmt->fetchAll(\PDO::FETCH_CLASS, "App\Entity\Users");
      $stmt->closeCursor();
      $conn->close();

      return $result;
    }
}

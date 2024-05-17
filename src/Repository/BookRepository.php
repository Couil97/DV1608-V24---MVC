<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getTotalCount(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(*)
            FROM book;
        ;';

        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }

    public function searchDb($search): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT *
            FROM book
            WHERE
                title   LIKE ? OR
                ISBN    LIKE ? OR
                author  LIKE ? OR
                id      LIKE ?
            LIMIT 1
        ;';

        $resultSet = $conn->executeQuery($sql, [$search, $search, $search, $search]);
        return $resultSet->fetchAllAssociative();
    }

    public function toArray($incBooks): array
    {
        $books = [];

        foreach($incBooks as $book) {
            $books = [
                'title' => $book->getTitle(),
                'ISBN' => $book->getISBN(),
                'author' => $book->getAuthor(),
                'id' => $book->getId()
            ];
        }

        return $books;
    }

    public function searchISBN($search): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT *
            FROM book
            WHERE ISBN LIKE ?
        ;';

        $resultSet = $conn->executeQuery($sql, [$search]);
        return $resultSet->fetchAllAssociative();
    }

    public function getHeaders(): array
    {
        return [
            [
                'english' => 'title',
                'swedish' => 'Titel'
            ],
            [
                'english' => 'ISBN',
                'swedish' => 'ISBN'
            ],
            [
                'english' => 'author',
                'swedish' => 'Författare'
            ]
        ];
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

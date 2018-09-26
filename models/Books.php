<?php


class Books
{
    /**
     * Get all list books with actors
     *
     * @return array
     */
    public static function getAllBooks()
    {
        $db = Db::getConnection();
        $books = $db->query('SELECT * FROM books ORDER BY title')->fetchAll();
        $stars = Stars::getAllStars($db);
        $result = [];

        foreach ($books as $book) {
            $bookStars = [];

            foreach ($stars as $star) {
                if ($book['id'] == $star['books_id']) {
                    $bookStars[] = $star;
                }
            }
            $book['stars'] = $bookStars;
            $result[] = $book;
        }
        Db::closeDbConnection($db);

        return $result;
    }

    /**
     * Get one book to ID from DB
     *
     * @param $id
     * @return array
     */
    public static function getBookById($id)
    {
        $db = Db::getConnection();
        $book = $db->query('SELECT * FROM books WHERE id =' . $id)
            ->fetchAll(PDO::FETCH_ASSOC);
        $star = Stars::getStarsByBookId($db, $id);

        (!empty($star)) ? $book[0]['stars'] = $star : null;
        Db::closeDbConnection($db);

        return $book;
    }

    /**
     *
     *
     * @return bool
     */
    public static function createBooks()
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO books (name, sort_order, status) '
            . 'VALUES (:name, :sort_order, :status)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Delete Book and stars from db
     *
     * @param integer $id
     * @return bool
     */
    public static function deleteBookById($id)
    {
        $db = Db::getConnection();
        $queryDeleteBook = 'DELETE FROM books WHERE id = :id';
        if (!empty($id)) {
            $deleteBook = $db->prepare($queryDeleteBook);
            $deleteBook->bindParam(':id', $id, PDO::PARAM_INT);
            $deleteBook->execute();

            Stars::deleteStars($db,$id);
        }
        Db::closeDbConnection($db);

        return true;
    }



}

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
        try {
            $db = Db::getConnection();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $insertQuery = "INSERT INTO books (title, release_year, format) VALUES 
            ('{$_POST['title']}', {$_POST['year_release']}, '{$_POST['format']}');";
            $result = $db->exec($insertQuery);

        } catch (PDOException $e) {
            echo $insertQuery . "<br>" . $e->getMessage();
        }
        if (isset($result)) {
            return $db->lastInsertId();
        }
        Db::closeDbConnection($db);

        return false;
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

            Stars::deleteStars($db, $id);
        }
        Db::closeDbConnection($db);

        return true;
    }


}

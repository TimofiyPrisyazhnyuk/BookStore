<?php

class Books
{

    /**
     * Get all list books with actors
     *
     * @param string $sort
     * @param null $search
     * @return array
     */
    public static function getAllBooks($sort = 'ASC', $search = null)
    {
        $db = Db::getConnection();
        if (isset($search)) {
            $books = $db->query("SELECT * FROM books WHERE books.title LIKE '%{$search}%'")
                ->fetchAll(PDO::FETCH_ASSOC);

            $stars = $db->query("SELECT DISTINCT books_id FROM stars WHERE stars.first_name LIKE '%{$search}%' 
             OR stars.last_name LIKE '%{$search}%'")->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($stars)) {
                $starsId = [];
                for ($i = 0; $i < count($stars); $i++) {
                    $starsId[] = ($i == 0) ? $stars[$i]['books_id'] : 'OR id=' . $stars[$i]['books_id'];
                }
                $getStarBook = $db->query("SELECT * FROM books WHERE id =" . implode(' ', $starsId))
                    ->fetchAll(PDO::FETCH_ASSOC);
                foreach ($getStarBook as $item) {
                    (!in_array($item, $books)) ? $books[] = $item : null;
                }
            }
        } else {
            $books = $db->query("SELECT * FROM books ORDER BY title {$sort}")
                ->fetchAll(PDO::FETCH_ASSOC);
        }
        $result = self::implodeResult($books, Stars::getAllStars($db));
        Db::closeDbConnection($db);

        return $result;
    }

    /**
     *  Resort result to new array
     *
     * @param $books
     * @param $stars
     * @return array
     */
    public static function implodeResult($books, $stars)
    {
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
     * Create new Book and return id new BOOK
     *
     * @param bool $book
     * @return bool
     */
    public static function createBooks($book = false)
    {
        $db = Db::getConnection();

        if (!empty($_POST)) {
            $newBook = [
                htmlspecialchars($_POST['title']),
                htmlspecialchars($_POST['year_release']),
                htmlspecialchars($_POST['format'])
            ];
        } else if ($book) {
            $newBook = [
                htmlspecialchars(trim($book[0][1])),
                htmlspecialchars($book[1][1]),
                htmlspecialchars(trim($book[2][1]))
            ];
        }
        try {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $insertQuery = "INSERT INTO books (title, release_year, format) VALUES 
            ('$newBook[0]', $newBook[1], '$newBook[2]');";
            $result = $db->exec($insertQuery);

        } catch (PDOException $e) {
            echo $insertQuery . "<br>" . $e->getMessage();
        }
        if (isset($result))
            return $db->lastInsertId();

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

<?php


class BookController
{

    /**
     * Basic views first page Books List
     */
    public function actionIndex()
    {
        if (!empty($_POST['sort'])) {
            $books = Books::getAllBooks($_POST['sort']);
            $selected = $_POST['sort'];
        } else if (!empty($_POST['search'])) {
            $books = Books::getAllBooks('ASC', $_POST['search']);
        } else {
            $books = Books::getAllBooks();
        }
        require_once(ROOT . '/view/books/list.php');

        return true;
    }

    /**
     * Show page create new Book or validate and Save new Book
     */
    public function actionCreate()
    {
        $errors = null;
        if (isset($_POST['create_books']) && $_POST['create_books'] == 1) {
            $validate = Validate::booksValidator();
            if (!empty($validate)) {
                $errors = $validate;

            } else {
                $saveBook = Books::createBooks();
                ($saveBook) ? Stars::createStars($saveBook) : null;

                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
                exit;
            }

        }
        require 'view/books/create.php';

        return true;
    }

//    /**
//     * Create and insert new Book to Db with stars
//     */
//    public function actionSave()
//    {
//        if($_POST['create_books'] == 1){
//            $validate = Validate::booksValidator();
//            if(!empty($validate)){
//                $errors = $validate;
//                require 'view/books/create.php';
//                return true;
//            }
//            die(var_dump($validate));
//            $saveBook = Books::createBooks();
//
//            $saveBook = Stars::createStars();
//        }
//
//        die(1);
//
//        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
//        exit;
//    }

    /**
     * Show page Read  One Book
     *
     * @param $id
     * @return bool
     */
    public function actionRead($id)
    {
        $result = Books::getBookByID($id);
        require 'view/books/read.php';

        return true;
    }

    /**
     * Delete book from db  and redirect to Books List
     *
     * @param $id
     * @return void
     */
    public function actionDelete($id)
    {
        Books::deleteBookById($id);

        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
        exit;
    }

}

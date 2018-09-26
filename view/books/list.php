<?php $title = 'List Books' ?>

<?php ob_start() ?>
    <div class="my-3">
        <div class="text-secondary">
            <h1>List Books</h1>
        </div>
        <div class="my-2">
            <div class="float-right my-3">
                <form class="form-inline my-lg-0">
                    <input class="form-control float-left mr-sm-2" type="search" placeholder="Search"
                           aria-label="Search" value="" name="search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="float-right m-3">
                <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/book/create' ?>"
                   class="btn btn-outline-success btn-md ">
                    CRETE NEW BOOK</a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-center">
        <table class="table nowrap table-bordered ">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>
                    <div class="float-left"> Title</div>
                    <form action="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/' ?>" method="POST">
                        <select name="sort" title="sort">
                            <option value="ASC" <?= ($selected == 'ASC') ? 'selected' : '' ?>>Sort A-Z</option>
                            <option value="DESC" <?= ($selected == 'DESC') ? 'selected' : '' ?>>Sort Z-A</option>
                        </select>
                        <button type="submit" class="fa fa-search app-sort" aria-hidden="true"></button>
                    </form>
                </th>
                <th>Release year</th>
                <th>Format</th>
                <th>Actors</th>
                <th>Control</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($books)):
                foreach ($books as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['release_year'] ?></td>
                        <td><?= $row['format'] ?></td>
                        <td>

                            <?php
                            if (!empty($row['stars'])) {
                                foreach ($row['stars'] as $item) {
                                    echo "<div><span class='badge badge-warning'>" .
                                        $item['first_name'] . ' ' . $item['last_name'] . "</span></div>";
                                }
                            } else
                                echo "<i class='text-danger'>Actors not found</i>";
                            ?>

                        </td>
                        <td><a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/book/read/' . $row['id'] ?>"
                               class="btn btn-success btn-xs"> Detail</a>
                            <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/book/delete/' . $row['id'] ?>"
                               onclick="return confirm('You sure to have delete this book?')"
                               class="btn btn-danger btn-xs">
                                Delete</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            else: echo "<tr><td colspan='6'>We not found Books in the store</td></tr>";
            endif;
            ?>
            </tbody>
        </table>
    </div>
<?php $content = ob_get_clean() ?>

<?php include 'view/index.php' ?>
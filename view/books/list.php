<?php $title = 'List Books' ?>

<?php ob_start() ?>

    <div class="my-3">
        <div class="text-secondary">
            <h1>List Books</h1>
        </div>
        <div class="float-right my-2">
            <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/book/create' ?>"
               class="btn btn-outline-success btn-sm pull-right">
                CRETE NEW BOOK</a>
        </div>
    </div>

    <div class="table-responsive text-center">
        <table class="table nowrap table-bordered ">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Release year</th>
                <th>Format</th>
                <th>Actors</th>
                <th>Control</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!empty($books)):
            foreach ($books as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['release_year'] ?></td>
                    <td><?= $row['format'] ?></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                    data-toggle="dropdown">
                                Book actors
                            </button>
                            <div class="dropdown-menu">
                                <?php
                                if (!empty($row['stars'])) {
                                    foreach ($row['stars'] as $item) {
                                        echo "<b class='dropdown-item'>{$item['first_name']}  {$item['last_name']}</b>";
                                    }
                                } else
                                    echo "<b class='dropdown-item'>Actors this book unknown</b>";
                                ?>
                            </div>
                        </div>
                    </td>
                    <td><a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/book/read/' . $row['id'] ?>"
                           class="btn btn-success btn-xs"> Detail</a>
                        <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/book/delete/' . $row['id'] ?>"
                           onclick="return confirm('Anda yakin akan menghapus data ini?')"
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
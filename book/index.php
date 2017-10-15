<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
//if (!is_logged_in())
//redirect_to("login.php"); //Redirect user to Login if not logged in

$book_query = sprintf("SELECT * FROM app_book WHERE isActive='%s' AND bookStatus='%s'", ACTIVE, STATE_SUCCESS);
$book_result = $connection->query($book_query);

include "../includes/header.php";
include "../includes/navbar.php"
?>
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <table class="table table-light">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if ($book_result && $book_result->num_rows) {
                    $count = 0;
                    while ($book = $book_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$count; ?></th>
                            <td><?php echo $book['bookName']; ?></td>
                            <td><?php echo $book['authorID']; ?></td>
                            <td><?php echo $book['categoryID']; ?></td>
                            <td><?php echo $book['bookID']; ?></td>
                        </tr>
                        <?php
                    }
                } else {

                    ?>
                    <tr>
                        <th colspan="5" class="text-center">It's Lonely Here</th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
?>

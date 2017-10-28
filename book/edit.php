<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
if (!is_logged_in())
    redirect_to(APP_ROOT . "/login.php"); //Redirect user to Login if not logged in

if (!isset($_GET['bookID']))
    redirect_to(APP_ROOT . "/book/index.php");

$bookID = $connection->real_escape_string(trim($_GET['bookID']));

$book_query = sprintf("SELECT * FROM app_book WHERE bookID='%s'", $bookID);
$book_result = $connection->query($book_query);

$book = $book_result->fetch_assoc();

if (!$book)
    redirect_to(APP_ROOT . "/book/index.php");

$category_query = sprintf("SELECT * FROM app_category WHERE isActive='%s' AND categoryStatus='%s'", ACTIVE, STATE_SUCCESS);
$category_result = $connection->query($category_query);

$author_query = sprintf("SELECT * FROM app_author WHERE isActive='%s' AND authorStatus='%s'", ACTIVE, STATE_SUCCESS);
$author_result = $connection->query($author_query);

if (isset($_POST['action']) && $_POST['action'] == 'editBook') {

    $name = $connection->escape_string(trim($_POST['txtBookName']));
    $author = $connection->escape_string(trim($_POST['selectAuthor']));
    $category = $connection->escape_string(trim($_POST['selectCategory']));
    $file = $connection->escape_string(trim($_FILES['fileBook']['name']));
    $cover = $connection->escape_string(trim($_FILES['fileCover']['name']));

    $has_error = false;
    $error_message = [];

    if (empty($name)) {
        $has_error = true;
        $error_message["txtBookName"] = "Please Enter Book Name";
    }

    if (empty($author)) {
        $has_error = true;
        $error_message["selectAuthor"] = "Please Enter Book Author";
    } elseif ($author == "-1") { //if author is other
        $txt_author = $connection->escape_string(trim($_POST['txtAuthor']));

        if (empty($txt_author)) {
            $has_error = true;
            $error_message["txtAuthor"] = "Please Enter Book Author";
        } else {
            $check_query = sprintf("SELECT * FROM app_author WHERE LOWER(authorName)='%s'", strtolower($txt_author));
            $check_result = $connection->query($check_query);

            echo $check_query;
            if ($check_result->num_rows) {
                $has_error = true;
                $error_message["txtAuthor"] = "Please Select Author from Dropdown";
            }

        }
    }


    if (empty($category)) {
        $has_error = true;
        $error_message["selectCategory"] = "Please Enter Book Category";
    }


    if (!empty($file)) {
        $bookFileType = pathinfo(basename($_FILES['fileBook']["name"]), PATHINFO_EXTENSION);

        if (!in_array($bookFileType, ["pdf"])) {
            $has_error = true;
            $error_message["fileBook"] = "Invalid Extension";
        } elseif ($_FILES['fileBook']["size"] > 50000000) {
            $has_error = true;
            $error_message["fileBook"] = "File is too Large";
        }
    }


    if (!empty($cover)) {
        $coverFileType = pathinfo(basename($_FILES['fileCover']["name"]), PATHINFO_EXTENSION);

        if (!in_array($coverFileType, ["jpg", "jpeg", "png"])) {
            $has_error = true;
            $error_message["fileCover"] = "Invalid Extension";
        } elseif ($_FILES['fileCover']["size"] > 50000000) {
            $has_error = true;
            $error_message["fileCover"] = "File is too Large";
        }
    }


    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {

        if (isset($txt_author)) {
            $author_args = [
                "authorName" => $txt_author,
                "authorStatus" => STATE_SUCCESS,
                "isActive" => ACTIVE
            ];
            $author = insert_query($connection, "app_author", $author_args);
        }
        if ($author) {
            $args = [
                "bookName" => $name,
                "authorID" => $author,
                "categoryID" => $category
            ];

            $updated_rows = update_query($connection, "app_book", $args, [
                "bookID" => $book['bookID']
            ]);

            if ($updated_rows || !empty($cover) || !empty($file) ) {
                $success_message = "Book Successfully Updated";

                if($updated_rows){
                    $book_result = $connection->query($book_query);
                    $book = $book_result->fetch_assoc();
                }

                if (!empty($file)) {
                    $file_response = upload_files(
                        [
                            "filename" => $book['bookID'] . "_file",
                            "FILES" => $_FILES['fileBook']
                        ], "books/");

                    if (!$file_response['status']) {
                        $error_message["fileBook"] = $file_response['message'];
                    }
                    if ($file_response['status']) {
                        $args = [
                            "bookFileLocation" => $file_response['name'],
                        ];
                        update_query($connection, "app_book", $args, [
                            "bookID" => $book['bookID']
                        ]);
                    }
                }

                if (!empty($cover)) {
                    $cover_response = upload_files(
                        [
                            "filename" => $book['bookID'] . "_cover",
                            "FILES" => $_FILES['fileCover']
                        ], "books/");

                    if (!$cover_response['status']) {
                        $error_message["fileBook"] = $cover_response['message'];
                    }
                    if ($cover_response['status']) {
                        $args = [
                            "bookCover" => $cover_response['name'],
                        ];
                        update_query($connection, "app_book", $args, [
                            "bookID" => $book['bookID']
                        ]);
                    }
                }


            } else {
                $error_message["form"] = "Unable to Add Book At the Moment. Please Try again Later";
            }
        } else {
            $error_message["form"] = "Unable to Add Author At the Moment.";
        }
    }
}

include "../includes/header.php";
include "../includes/navbar.php"
?>
<div class="container">
    <div class="row mt-5">
        <div class="col form-portlet">
            <?php if (isset($error_message["form"])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message["form"] ?>
                </div>
            <?php } elseif (isset($success_message)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message ?>
                </div>
            <?php } ?>
            <form method="post" action="#" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtBookName">Book Name</label>
                    <input type="text"
                           class="form-control  <?php echo isset($error_message['txtBookName']) ? 'is-invalid' : '' ?>"
                           value="<?php echo $book['bookName'] ?>"
                           id="txtBookName" name="txtBookName">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['txtBookName']) ? $error_message['txtBookName'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectAuthor">Author Name</label>
                    <select
                            class="form-control  <?php echo isset($error_message['selectAuthor']) ? 'is-invalid' : '' ?>"
                            name="selectAuthor" id="selectAuthor">
                        <option value="">Select Author</option>
                        <option value="-1">Other</option>
                        <?php while ($author = $author_result->fetch_assoc()) {
                            ; ?>
                            <option
                                    value="<?php echo $author['authorID']; ?>"
                                <?php echo $book['authorID'] == $author['authorID'] ? "selected" : "" ?>
                            ><?php echo $author['authorName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectAuthor']) ? $error_message['selectAuthor'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtAuthor">Author Name</label>
                    <input type="text"
                           class="form-control  <?php echo isset($error_message['txtAuthor']) ? 'is-invalid' : '' ?>"
                           id="txtAuthor" name="txtAuthor">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['txtAuthor']) ? $error_message['txtAuthor'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectCategory">Category Name</label>
                    <select
                            class="form-control  <?php echo isset($error_message['selectCategory']) ? 'is-invalid' : '' ?>"
                            name="selectCategory" id="selectCategory">
                        <option value="">Select Category</option>
                        <?php while ($category = $category_result->fetch_assoc()) { ?>
                            <option
                                    value="<?php echo $category['categoryID']; ?>"
                                <?php echo $book['categoryID'] == $category['categoryID'] ? "selected" : "" ?>
                            ><?php echo $category['categoryName']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectCategory']) ? $error_message['selectCategory'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileBook">Book File</label>
                    <input type="file"
                           class="form-control-file form-control <?php echo isset($error_message['fileBook']) ? 'is-invalid' : '' ?>"
                           name="fileBook" id="fileBook">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['fileBook']) ? $error_message['fileBook'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileCover">Book Cover</label>
                    <input type="file"
                           class="form-control-file form-control <?php echo isset($error_message['fileCover']) ? 'is-invalid' : '' ?>"
                           name="fileCover" id="fileCover">
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['fileCover']) ? $error_message['fileCover'] : '' ?>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
                <a class="btn btn-danger" href="index.php">Cancel</a>
                <input type="hidden" name="action" value="editBook">

            </form>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
?>

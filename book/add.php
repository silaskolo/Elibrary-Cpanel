<?php
// Start Browser Session
session_start();

require_once "../config/functions.php";

//Check is User Session Exist i.e if user is logged in
//if (!is_logged_in())
//redirect_to("login.php"); //Redirect user to Login if not logged in

if (isset($_POST['action']) && $_POST['action'] == 'addBook') {

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
    }


    if (empty($category)) {
        $has_error = true;
        $error_message["selectCategory"] = "Please Enter Book Category";
    }


    if (empty($file)) {
        $has_error = true;
        $error_message["fileBook"] = "Please Add Book File";
    }


    if (empty($cover)) {
        $has_error = true;
        $error_message["fileCover"] = "Please Add Book Cover";
    }


    if ($has_error) {
        $error_message["form"] = sprintf("%d Error(s) found", count($error_message));
    } else {
        $args = [
            "bookName" => $name,
            "authorID" => $author,
            "categoryID" => $category,
            "bookStatus" => STATE_PENDING,
            "isActive" => ACTIVE
        ];
        $insert_id = insert_query($connection, "app_book", $args);

        if ($insert_id) {
            $success_message = "Book Successfully Added";

            $file_response = upload_files(
                [
                    "filename" => $insert_id . "_file",
                    "FILES" => $_FILES['fileBook'],
                    "allowed_ext" => [
                        "pdf"
                    ]
                ], "books/");

            if (!$file_response['status']) {
                $error_message["fileBook"] = $file_response['message'];
            }

            $cover_response = upload_files(
                [
                    "filename" => $insert_id . "_cover",
                    "FILES" => $_FILES['fileCover'],
                    "allowed_ext" => [
                        "jpg",
                        "jpeg",
                        "png"
                    ]
                ], "books/");

            if (!$cover_response['status']) {
                $error_message["fileBook"] = $cover_response['message'];
            }

            if ($file_response['status'] && $cover_response['status']) {
                $args = [
                    "bookName" => $name,
                    "bookFileLocation" => $file_response['name'],
                    "bookCover" => $cover_response['name'],
                    "bookStatus" => STATE_SUCCESS
                ];
                update_query($connection, "app_book", $args, [
                    "bookID" => $insert_id
                ]);
            }

        } else {
            $error_message["form"] = "Unable to Add Book At the Moment. Please Try again Later";
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
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($error_message['selectAuthor']) ? $error_message['selectAuthor'] : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectCategory">Category Name</label>
                    <select
                            class="form-control  <?php echo isset($error_message['selectCategory']) ? 'is-invalid' : '' ?>"
                            name="selectCategory" id="selectCategory">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
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
                <button class="btn btn-danger" type="submit">Add Book</button>
                <input type="hidden" name="action" value="addBook">

            </form>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
?>

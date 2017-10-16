<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img src="<?php echo APP_ROOT; ?>/assets/img/logo_white.png" alt="..." class="navbar-img"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo APP_ROOT; ?>/index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="BooksLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Books
                </a>
                <div class="dropdown-menu" aria-labelledby="BooksLink">
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/book/index.php">View</a>
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/book/add.php">Add</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="QuestionsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Past Questions
                </a>
                <div class="dropdown-menu" aria-labelledby="QuestionsLink">
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/question/index.php">View</a>
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/question/add.php">Add</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="AdminLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin
                </a>
                <div class="dropdown-menu" aria-labelledby="AdminLink">
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/admin/user.php">Users</a>
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/admin/course.php">Courses</a>
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/admin/department.php">Departments</a>
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/admin/faculty.php">Faculty</a>
                    <a class="dropdown-item" href="<?php echo APP_ROOT; ?>/admin/category.php">Category</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo APP_ROOT; ?>/logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
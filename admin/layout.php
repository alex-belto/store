<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type = "text/css" href = "">
    </head>
    <body>
        <header>
            <ul>
                <li><a href = "../index.php">Some Store</a></li>
                <li><a href = "?users">Users</a></li>
                <li><a href = "?products">Products</a></li>
                <li><a href = "signOut.php">Sign Out</a></li>
            </ul>
        </header>
        <main>
            <?= $formContent ?>
            <?php if(isset($_SESSION['message'])) echo $_SESSION['message']; unset($_SESSION['message']); ?>
            <?= $content ?>
            
        </main>
        <footer>
        </footer>
    </body>
</html>
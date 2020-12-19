<!DOCTYPE html>
<html>
    <head>
        <title>Some Store</title>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type = "text/css" href = "">
    </head>
    <body>
        <header>
            <ul>
                <li><a href = "?index">Some Store</a></li>
                <li><a href = "?catalog">Каталог Товаров</a></li>
                <?php if(isset($_GET['catalog'])){
                     echo $category;
                } ?>
                <?php if(!empty($subCategory)){
                     echo $subCategory;
                } ?>
                <li><a href = "?contacts">Контакты</a></li>
                <li><a href = "?basket">Корзина</a></li>
                <?php
                    if(isset($_SESSION['auth'])){?>
                        <li><a href = "?logout">Выйти</a></li>
                        <?= $_SESSION['login'] ?>
                 <?php   }?>
                 <?php
                    if(!isset($_SESSION['auth'])){?>
                        <li><a href = "?login">Войти</a></li>
                        <li><a href = "?registration">Зарегистрироваться</a></li>
                 <?php   }?>
                    
            </ul>
        </header>
        <main>
            <?php if(isset($_SESSION['message'])) echo $_SESSION['message']; unset($_SESSION['message']); ?>
            <?= $formContent ?>
            <?= $basket ?>
            <?= $content ?>
            
           
        </main>
        <footer>
        </footer>
    </body>
</html>
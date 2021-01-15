<?php
include 'include.php';
include 'form.php';
$content = '';
$formContent = '';


if(!empty($_GET)){//аппарат вывода форм
    preg_match_all('#\?([A-Za-z]{3,16})#', $_SERVER['REQUEST_URI'],  $matches);
    $formName =  $matches['1']['0'];

    switch ($formName){
        case 'registration':
            $formContent = registrationForm();
            break;
        case 'login':
            $formContent = loginForm();
            break;
        
    }
    
}

function registration($link){
   if(isset($_GET['registration'])){
       if(!empty($_POST['name']) AND !empty($_POST['age']) AND !empty($_POST['age']) AND !empty($_POST['email'])AND !empty($_POST['phone'])
       AND !empty($_POST['login']) AND !empty($_POST['password']) AND !empty($_POST['confirm'])){
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone'];
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        
        if($_POST['password'] == $_POST['confirm'] AND preg_match('#^[A-Za-z0-9]{7,32}$#', $_POST['password']) == 1){//password

            $query = "SELECT login FROM users WHERE login = '$login'";
            $checkLogin = mysqli_fetch_assoc(mysqli_query($link, $query));
            if(empty($checkLogin) AND preg_match('#^[A-Za-z0-9_-]{4,32}$#', $login) == 1 ){//login
               
                if(preg_match('#^[a-z0-9\._-]{3,16}\@[a-z]{4,8}\.[a-z]{2,4}$#', $email)){//email

                    $query = "INSERT INTO users (name, age, email, phone_number, login, password, status, role ) 
                    VALUES ('$name', '$age', '$email', '$phone_number', '$login', '$password', 'active', 'user')";
                    mysqli_query($link, $query) or die(mysqli_error($link));

                    $_SESSION['message'] = 'Регистрация прошла успешно, авторизируйтесь для входа на сайт';
                    header('location: index.php?login');die();

                    }else{
                        $_SESSION['message'] ='Ваш email не соответствует формату, пожалуйста проверьте введенный вами email';
                    }
                
                }else{
                    $_SESSION['message']= 'Данный логин не соответствует требованиям:</br>
                                            1)Убедитесь что ваш логин состоит исключительно из символов латинского алфавита и цифр от 0 до 9</br>
                                            2)В инном случае, ваш логин занят другим пользователем, попробуйте изменить его!';
                }

            }else{
                $_SESSION['message'] = 'Ошибка регистрации, проверьте написание пароля и совпадение его с проверочным паролем!';
            }
        
       }elseif(!empty($_POST['submit'])){
            $_SESSION['message'] = 'Не все поля заполнены! Зполните все поля!';
       }
       
   }
}

function login($link){
    if(!empty($_POST['login']) AND !empty($_POST['password'])){
        $login = $_POST['login'];

        $query = "SELECT * FROM users WHERE login = '$login'";
        $user = mysqli_fetch_assoc(mysqli_query($link, $query));

        if(!empty($user)){
            $hash = $user['password'];
            $password = password_verify($_POST['password'], $hash);
            $status = $user['status'];

            if($status == 'active'){
                if($hash == $password){
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['login'] = $user['login'];
                    $_SESSION['phone_numb'] = $user['phone_numb'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['status'] = $user['status'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['message'] = 'Авторизация успешна';
                    header('location: index.php'); die();
                }else{
                    $_SESSION['message'] = 'Авторизация успешна';
                }
            }else{
                $_SESSION['message'] = 'Доступ к сайту запрещен модератором, обратитесь в поддержку для урегулирования вопроса.';
            }
        }else{
            $_SESSION['message'] = 'Пользователя с такими данными не существует, зарегиструрейтесь для доступа ко всем функциям сайта!';
        }
    }
}

function logout(){
    if(isset($_GET['logout'])){
        session_destroy();
        header('location: index.php');
    }
}

function getContent($link, $content){
   
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        $notesOnPage = '5';
        $referencePoint = ($page - 1) * $notesOnPage;
    
        preg_match_all('#\?[A-Za-z]{3,16}&&[A-Za-z_]{3,16}&&([A-Za-z_]{3,16})#', $_SERVER['REQUEST_URI'],  $matches);
        if(!empty($matches['1']['0'])){
            $subCategoryUrl = $matches['1']['0'];
        }
        if(empty($subCategoryUrl)){
            $query = "SELECT * FROM products LIMIT $referencePoint, $notesOnPage";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
        }else{
            $query = "SELECT sub_category.id as sub_id, sub_category.url as sub_url, subCategoryId, description, price, quantity, product, products.id as id  FROM products
            RIGHT JOIN sub_category ON products.subCategoryId = sub_category.id WHERE sub_category.url = '$subCategoryUrl'";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
        }
        
        //var_dump($arr);
        if(!empty($arr)){
            
        foreach($arr as $value){
            $productId = $value['id'];
            $product = $value['product'];
            $quantity = $value['quantity'];
            $price = $value['price'];
            $description = $value['description'];
            $content .= "<table cellspacing='4'> ";
            $content .= "
            <tr>
                <td>$product</td>
            </tr>
            <tr>
                <td>Кол-во:$quantity  Цена: $price</td>
                
            </tr>
            <tr>
                <td>$description</td>
            </tr>";
            $content.= "</table>";
            $content .= "
            <form action='' method='POST'>
                <input type='hidden' name='productId' value='$productId'>
                <input type='submit' name='buy' value='Купить'><br><br>
            </form>";
        }
            $query = "SELECT COUNT(*) as count FROM products";
            $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
            $numbsOfPage = ceil($count/$notesOnPage);
    
            if(!empty($_GET)){
                preg_match_all('#\?([A-Za-z0-9]{3,16})#', $_SERVER['REQUEST_URI'], $matches);//для того что бы переход на страницу не сносил на пустую адрес строку
                $requestUri = $matches['1']['0'];
                //echo $requestUri;
            }
            for($i = 1; $i <= $numbsOfPage; $i++){
                if(!empty($requestUri)){
                    $content .= "<a href = 'index.php?$requestUri&&page=$i'>$i</a>";
                }else{
                    $content .= "<a href = '?page=$i'>$i</a>";
                }
            }
    
        
        }else{
            echo 'пустой масив';
        }
        return $content;
    
    
}

function getCategory($link){
    
    $query = "SELECT id, name, url FROM category";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
    $category = '';
    foreach($arr as $value){
        $name = $value['name'];
        $url = $value['url'];
        $category.= "<li><a href = '?catalog&$url'>$name</a></li>";
        
    }
    
    return $category;
}

function getSubCategory($link){

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = '1';
    }

    if(!empty($_GET)){
        // if(isset($_GET['page'])){
        //     preg_replace('#.page=/d#', $_SERVER['REQUEST_URI'], '');
        // }
        preg_match_all('#\?[A-Za-z]{3,16}&([A-Za-z_]{3,16})#', $_SERVER['REQUEST_URI'],  $matches);
        if(!empty($matches['1']['0'])){
            $subCategoryUrl = $matches['1']['0'];
        }
       
    } 
    if(!empty($subCategoryUrl)){
        $subCategory = '';
        $query = "SELECT category.url as url, sub_category.id as sub_id, sub_category.name as sub_name, sub_category.url as sub_url FROM sub_category
            RIGHT JOIN  category  ON category_id = category.id";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);

            
            foreach($arr as $value){
                    $category[$value['url']][] = $value['sub_name'];
                    
                }

            $urlSubCategory = $category[$subCategoryUrl];
            
            foreach($urlSubCategory as $value){
                $name = $value;
                $query = "SELECT url FROM sub_category WHERE name = '$name'";
                $result = mysqli_fetch_assoc(mysqli_query($link, $query));
                $url = $result['url'];
                $subCategory.= "<li><a href = '?catalog&&$subCategoryUrl&&$url'>$name</a></li>";
                }
                return $subCategory;
    }
}

function addToBasket($link){
    if(isset($_POST['buy'])){

        $_SESSION['products'] = $_POST['productId'];
        $_SESSION['message'] = 'Товар добавлен в корзину!';
        header('location: index.php?index');
        //var_dump($_SESSION);
    }

}

function basket($link){

    if(isset($_SESSION['products'])){
        $_SESSION['basket'][] = $_SESSION['products'];
        unset($_SESSION['products']);
    }

    if(isset($_GET['basket'])){
           
        
        if(!empty($_SESSION['basket'])){
            $productsId = '';
            
            $_SESSION['basket'] = array_unique($_SESSION['basket']);
        
        //array_pop($_SESSION['basket']);
        
        ?><pre><?php
            //var_dump($_SESSION['basket']);
        ?></pre><?php
        
        $productsId = implode(',', $_SESSION['basket']);
        $productsId = trim($productsId, ',');
        //echo $productsId;
    
    
    if(isset($_POST['dellFromBasket'])){
        $quant = count($_SESSION['basket']);
        if($quant > 1){
            $dellId = $_POST['productId'];
            $_SESSION['basket'] = array_diff($_SESSION['basket'], [$dellId]);
            $productsId = implode(',', $_SESSION['basket']);
        }else{
            $dellId = $_POST['productId'];
            $_SESSION['basket'] = array_diff($_SESSION['basket'], [$dellId]);
            $productsId = implode(',', $_SESSION['basket']);
            header('location: index.php?basket'); die();
        }
        
       
    ?><pre><?php
        //var_dump($_SESSION['basket']);
    ?></pre><?php
    }
    if(isset($_POST['deal'])){
        ?><pre><?php
            var_dump($_POST);
        ?></pre><?php
       //регуляркой перебрать post
        $productsId= '';
        unset($_SESSION['basket']);
        $_SESSION['message'] = 'Заказ оформлен, ждите оповещения от оператора на ваш номер телефона!';
    }else{

        $query = "SELECT id, product, quantity, price, description FROM products WHERE id IN ($productsId)";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
            
        // ?><pre><?php
            //var_dump($arr);
        // ?></pre><?php
        if(!empty($arr)){
            foreach($arr as $value){
                $productId = $value['id'];
                $product = $value['product'];
                $quantity = $value['quantity'];
                $price = $value['price'];
                $description = $value['description'];
    
                $basket[$value['id']]['table'] = "
                <tr>
                    <td>$product</td>
                </tr>
                <tr>
                    <td> В наличии: $quantity Цена: $price</td>
                    
                </tr>
                <tr>
                    <td>$description</td>
                </tr>";
                
                $basket[$value['id']]['form'] = "
                
                    <input type='hidden' name='productId_$productId' value='$productId'>
                    <br>Количество:
                    <input type='text' name='quantity_$productId' value='1'>

                    <input type='submit' name='dellFromBasket' value='$productId'></br></br>";
            }
            $basketForm = '';
            
            foreach($basket as $value){
    
    
                $basketForm .="<table>";
                        $basketForm.= $value['table'];
                $basketForm .="</table>";
        
                $basketForm .="<form action='' method='POST'>";
                
                            $basketForm .= $value['form'];
            
        }
                $basketForm .="<input type='submit' name='deal' value='Оформить заказ'>";
                $basketForm .="</form>";
        
        }
           
            return $basketForm;
        }
    
        }else{
            $_SESSION['message'] = 'Корзина пуста!';
        }
        
    }   
    
}




logout();
login($link);
$category = getCategory($link);
$subCategory = getSubCategory($link);
if(!isset($_GET['basket'])){
    $content = getContent($link, $content);
}

$basket = basket($link);
registration($link);
addToBasket($link);



include 'layout.php';
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

logout();
login($link);
registration($link);
include 'layout.php';
<?php
include '../include.php';
include '../form.php';
$title = 'Some Store';
$formContent = '';
$content = '';

if(!empty($_GET)){//аппарат вывода форм
    preg_match_all('#\?([A-Za-z]{3,16})#', $_SERVER['REQUEST_URI'],  $matches);
    $formName =  $matches['1']['0'];
    
    //var_dump($matches);
    switch ($formName){
        case 'products':
            $title = 'Products';
            break;
        case 'addProducts':
            $formContent = addProductsForm();
            $title = 'Add Products';
            break;
        case 'login':
            $formContent = loginForm();
            $title = 'Login';
            break;
        case 'users':
            $title = 'Users';
            break;
        case 'profit':
            $formContent = profitButtonForm();
            $title = 'Profit';
            break;
        
    }
    
}


function addProducts($link){
    if(isset($_GET['addProducts'])){

        if(!empty($_POST['product']) AND !empty($_POST['quantity']) AND !empty($_POST['price']) AND !empty($_POST['description'])
        AND !empty($_POST['category']) AND !empty($_POST['subCategory'])){

            $product = $_POST['product'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            $subCategory = $_POST['subCategory'];
            $imgTmpName = $_FILES['product_img']['tmp_name'];//временное имя файла
            $imgName = $_FILES['product_img']['name'];//реальное имя файла
            $imgPath = '/Applications/MAMP/htdocs/Store/imgb/'.$_FILES['product_img']['name'];//путь к файлу
            

            $query = "SELECT id FROM category WHERE name = '$category'";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));//достаю категории
            
            $query = "SELECT id FROM sub_category WHERE name = '$subCategory'";//достаю подкатегории
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            $subCategoryId = mysqli_fetch_assoc($result)['id'];
            // var_dump($_FILES);
            
           
            move_uploaded_file($imgTmpName, $imgPath); //загрузка файла на диск


            $query = "INSERT INTO products (product, img, quantity, price, description,  subCategoryId) 
            VALUE ('$product', '$imgName', '$quantity', '$price', '$description', '$subCategoryId')";//вношу продукт в базу
            mysqli_query($link, $query) or die(mysqli_error($link));



            
            $_SESSION['message'] = 'Товар успешно добавлен';
            //header('location: /Store/admin/?products'); die();

        }elseif(!empty($_POST['submit'])){
                $_SESSION['message'] = 'Ошибка ввода, заполните все поля!'; 
        }
    }
    
}

function getContent($link, $content,$title){

    if(!empty($_GET)){
        preg_match_all('#\?([A-Za-z0-9]{3,16})#', $_SERVER['REQUEST_URI'], $matches);//для того что бы переход на страницу не сносил на пустую адрес строку
        $requestUri = $matches['1']['0'];
        //echo $requestUri;
    }

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
   

    if($title == 'Products'){

        $notesOnPage = '5';
        $referencePoint = ($page - 1) * $notesOnPage;//пагинация
        $query = "SELECT * FROM products LIMIT $referencePoint, $notesOnPage";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
        //var_dump($arr);
        $content .= "<button><a href='?addProducts'>Добавить товар</a></button><br><br>";
        if(!empty($arr)){
            $content .= "<table border='1px solid black'>
                            <tr>
                                <th>Название продукта</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Описание</th>
                            </tr>";
        foreach($arr as $value){
            $id = $value['id'];
            $product = $value['product'];
            $quantity = $value['quantity'];
            $price = $value['price'];
            $description = $value['description'];
            $content .= "
            <tr>
                <td>$product</td>
                <td>$quantity</td>
                <td>$price</td>
                <td>$description</td>
                <td><a href='?$requestUri&&edit=$id'>Редактировать</a></td>
                <td><a href='?$requestUri&&delete=$id'>Удалить</a></td>
                
            </tr>";
        }
        $content .= "</table>";
        }else{
            echo 'пустой масив';
        }
        $query = "SELECT COUNT(*) as count FROM products";
        $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
        $numbsOfPage = ceil($count/$notesOnPage);

        for($i = 1; $i <= $numbsOfPage; $i++){
            if(!empty($requestUri)){
                $content .= "<a href = 'index.php?$requestUri&&page=$i'>$i</a>";
            }else{
                $content .= "<a href = '?page=$i'>$i</a>";
            }
        }

    }
    if($title == 'Users'){

        if(!empty($_GET)){
            preg_match_all('#\?([A-Za-z0-9]{3,16})#', $_SERVER['REQUEST_URI'], $matches);//для того что бы переход на страницу не сносил на пустую адрес строку
            $requestUri = $matches['1']['0'];
            //echo $requestUri;
        }

        $notesOnPage = '5';
        $referencePoint = ($page - 1) * $notesOnPage;

        $query = "SELECT * FROM users LIMIT $referencePoint, $notesOnPage";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
        //var_dump($arr);
        
        if(!empty($arr)){
            $content .= "<table border='1px solid black'>
                            <tr>
                                <th>Имя</th>
                                <th>Статус</th>
                                <th>Роль</th>
                                
                            </tr>";
        foreach($arr as $value){
            $id = $value['id'];
            $name = $value['name'];
            $status = $value['status'];
            $role = $value['role'];
            
            $content .= "
            <tr>
                <td>$name</td>
                <td>$status</td>
                <td>$role</td>";
                if($role != 'admin'){
                if($status == 'active'){
                    $content .= "<td><a href='?$requestUri&&ban=$id'>Забанить</a></td>";
                }else{
                    $content .= "<td><a href='?$requestUri&&unban=$id'>Разбанить</a></td>";
                }
                
                $content .= "<td><form action ='index.php?users' method='GET'>
                                    <input type='hidden' name='users' value='1'>
                                    <select name='role'>
                                        <option value='user'>user</option>
                                        <option value='moderator'>moderator</option>
                                    </select>
                                    <input type='hidden' name='id' value=\"$id\">
                                    <input type='submit' value='Отправить'>
                                    </td></form>";
                }
                
        $content .= "</tr>";
        }
        $content .= "</table>";
        }else{
            echo 'пустой масив';
        }
        $query = "SELECT COUNT(*) as count FROM users";
        $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
        $numbsOfPage = ceil($count/$notesOnPage);

        for($i = 1; $i <= $numbsOfPage; $i++){
            if(!empty($requestUri)){
                $content .= "<a href = 'index.php?$requestUri&&page=$i'>$i</a>";
            }else{
                $content .= "<a href = '?page=$i'>$i</a>";
            }
        }
    }
    

    return $content;
}


function banUnban($link){
    if(isset($_GET['ban']) OR isset($_GET['unban'])){
        $id = '';
        $newStatus = '';
        if(isset($_GET['ban'])){
            $newStatus = 'baned';
            $id = $_GET['ban'];
        }elseif(isset($_GET['unban'])){
            $newStatus = 'active';
            $id = $_GET['unban'];
        }
        $query = "UPDATE users SET status = '$newStatus' WHERE id = '$id'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Статус обновлен!';
        //header('location: /Store/admin/?users'); die();
    }
}

function changeRole($link){
    if(isset($_GET['role'])){
        $newRole = $_GET['role'];
        $id = $_GET['id'];

        $query = "UPDATE users SET role = '$newRole' WHERE id = '$id'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Роль изменена!';
        //header('location: /Store/admin/?users'); die();
    }
}

function deleteProducts($link){
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $query = "DELETE FROM products WHERE id = '$id'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись удалена!';
    }
}

function editProductsForm($link){
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];

        $query = "SELECT * FROM products WHERE id = '$id'";
        $result = mysqli_fetch_assoc(mysqli_query($link, $query));
        $product = $result['product'];
        $quantity = $result['quantity'];
        $price = $result['price'];
        $description = $result['description'];
        $category = $result['category'];
        $subCategory = $result['subCategory'];

        return $formContent = "
            <form enctype='multipart/form-data' action='' method='POST'>
                <br><p>Название продукта:</p>
                <input type='text' name='product' value='$product'><br><br>
                <p>Введите имеющееся количество товара:</p>
                <input type='text' name='quantity' value='$quantity'><br><br>
                <p>Введите цену товара:</p>
                <input type='text' name='price' value='$price'><br><br>
                <p>Введите категорию товара:</p>
                <input type='text' name='category' value='$category'><br><br>
                <p>Введите подкатегорию товара:</p>
                <input type='text' name='subCategory' value='$subCategory'><br><br>
                <p>Введите описание товара:</p>
                <textarea name='description' >$description</textarea><br><br>
                <input type='submit' name='submitEditProduct' value='Отправить'><br><br>
            </form>";
    }
}
function editProduct($link){
    if(isset($_POST['submitEditProduct'])){
        $id = $_GET['edit'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $subCategory = $_POST['subCategory'];
       
        
        //var_dump($_POST);
        

        $query = "UPDATE products SET product = '$product', quantity = '$quantity', price = '$price', description = '$description',
        category = '$category', subCategory = $subCategory  WHERE id = '$id'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись изменена!';
        //header('location: /Store/admin/?users'); die();
    }
}

function profit($link){
    if(isset($_GET['profit'])){
        $content = '';
        //var_dump($_POST);

        $startPoint = time() - 2592000;
        if(isset($_POST['date'])){
            switch($_POST['date']){
                case 'day':
                    $startPoint = time() - 86400;
                    break;
                case 'month':
                    $startPoint = time() - 2592000;
                    break;
                case 'year':
                    $startPoint = time() - 31556926;
                    break;
            }
        }
        $time = time();
        $startDate = date('d.m.Y', $startPoint);
        $now = date('d.m.Y', time());

        $query = "SELECT SUM(amount) FROM profit WHERE date BETWEEN '$startPoint' AND '$time'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        
        for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
        $amount =  round($arr[0]['SUM(amount)'], 5);
        //var_dump($arr);


        $content = "
        <table>
            <tr>
                <th>Период</th>
                <th>Сумма</th>
            </tr>
            <tr>
                <td>$startDate - $now</td>
                <td>$amount</td>
            </tr>
        </table>";
        return $content;
    }
}

function logout(){
    if(isset($_GET['logout'])){
        session_destroy();
        header('location: index.php');
    }
}

addProducts($link);
banUnban($link);
changeRole($link);
deleteProducts($link);
if(isset($_GET['edit'])){
$formContent = editProductsForm($link);
}
editProduct($link);
$content = profit($link);
$content = getContent($link, $content, $title);


logout();

include 'layout.php';
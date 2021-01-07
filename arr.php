<?php
include 'include.php';
$formContent = '';
$content = '';
$dellId ='';
$str = '';
$arr = [];

if(empty($_SESSION['arr'])){
    $_SESSION['arr'] = [1,2,3,4,5,7,8];// массив в сессии
}

if(isset($_POST['dell'])){
   $dellId = $_POST['dell'];//id удаления
}



    $arr = array_diff($_SESSION['arr'], [$dellId]);//удаление 
    $_SESSION['arr'] = $arr;//перезапсь сессии
    ?>
    <pre>
         <?php var_dump($arr);?>
    </pre>
    
     <?php
    $productsId = implode(',', $arr);//разбивка массива в строку по запятой
    echo $productsId;
    
?>
            <form action='' method='POST'>
            
             <input type='text' name='dell' value=''>
             <input type='submit' name='submit' value='Отправить'>
             </form>
<?php 
die();

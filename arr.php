<?php
include 'include.php';
$formContent = '';
$content = '';

if(isset($_GET['page'])){
   $serverUri = preg_replace('#\?page\=.#', $_SERVER['REQUEST_URI'], '');
   echo $serverUri;
}


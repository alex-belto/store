<?php

    function registrationForm(){
        return $formContent = "
    <form action='' method='POST'>
        <p>Введите ваше Имя и Фамилию:</p>
        <input type='text' name='name'>
        <p>Введите ваш возраст:</p>
        <input type='text' name='age'>
        <p>Введите ваш email:</p>
        <input type='email' name='email'>
        <p>Введите номер вашего телефона:</p>
        <input type='tel' name='phone'>
        <p>Введите жедаемый логин:</p>
        <input type='text' name='login'>
        <p>Введите желаемый пароль</p>
        <input type='password' name='password'>
        <p>Подтвердите желаемый  пароль:</p>
        <input type='password' name='confirm'><br><br>
        <input type='submit' name='submit' value='Отправить'><br><br>
    </form>";
    }

    function loginForm(){
        return $formContent = "
            <form action='' method='POST'>
                <p>Введите ваш логин:</p>
                <input type='text' name='login'><br>
                <p>Введите ваш пароль:</p>
                <input type='password' name='password'><br><br>
                <input type='submit' name='submit' value='Отправить'><br><br>
            </form>";
    }

    function addProductsForm(){
        return $formContent = "
            <form action='' method='POST'>
                <br><p>Название продукта:</p>
                <input type='text' name='product'><br><br>
                <p>Введите имеющееся количество товара:</p>
                <input type='text' name='quantity'><br><br>
                <p>Введите цену товара:</p>
                <input type='text' name='price'><br><br>
                <p>Введите категорию товара:</p>
                <input type='text' name='category'><br><br>
                <p>Введите подкатегорию товара:</p>
                <input type='text' name='subCategory'><br><br>
                <p>Введите описание товара:</p>
                <textarea name='description'></textarea><br><br>
                <input type='submit' name='submit' value='Отправить'><br><br>
            </form>";
    }
    
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
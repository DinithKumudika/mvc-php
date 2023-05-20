<?php

/** register web application's routes here */

$router->get('/', 'Home/index');

$router->get('/user/login', 'User/login')->only('guest');
$router->post('/user/login', 'User/login')->only('guest');
$router->delete('/user/login', 'User/logout')->only('auth');

$router->get('/user/register', 'User/signup')->only('guest');
$router->post('/user/register', 'User/signup')->only('guest');

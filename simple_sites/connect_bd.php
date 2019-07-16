<?php 
// Соединение, выбор базы данных
$dbc = pg_connect("host= port= dbname= user= password=")
    or die('Не удалось соединиться: ' . pg_last_error());

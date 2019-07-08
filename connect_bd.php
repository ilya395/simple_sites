<?php 
// Соединение, выбор базы данных
$dbc = pg_connect("host=188.120.242.43 port=5432 dbname=dvm_group user=naomi_dev password=2C6c9Q6y")
    or die('Не удалось соединиться: ' . pg_last_error());
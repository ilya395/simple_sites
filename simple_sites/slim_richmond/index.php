<?php
require("../connect_bd.php");

$query = 'SELECT number, id FROM dj_buildings WHERE (project_id = 44 AND id != 361) ORDER BY number';
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Slim_Richmond</title>
</head>
<body>
	hi!

	<div class="main-container">
		<div class="container">
			
			<div class="build-container">
				<div class="build-number">
					<?php
						while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

						    //foreach ($line as $col_value) {
						    ?>
						    	Корпус: 
						    	<a href="catalog.php/?building=<?php echo $line['id'] ?>" class="build-link">
						    		<?php echo $line['number']; ?>
						    	</a>
						    	<br>
						    <?php
						    //}

						}
					?>
				</div>
			</div>
<?php

	// Очистка результата
	pg_free_result($result);

	// Закрытие соединения
	pg_close($dbc);

?>

		</div>
	</div>
	
</body>
</html>
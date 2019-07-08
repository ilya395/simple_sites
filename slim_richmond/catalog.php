<?php
require("../connect_bd.php");

$building_id = $_GET['building'];
$build_id = (int) $building_id;

$query_floor = "SELECT number, id, entrance FROM dj_sections WHERE building_id = '$build_id' AND project_id = 44 ORDER BY number";
$result_floor = pg_query($query_floor) or die('Ошибка запроса: ' . pg_last_error());

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Catalog!</title>
</head>
<body>

	<div class="main-container">
		<div class="container">
			<?php
				while ($line_floor = pg_fetch_array($result_floor, null, PGSQL_ASSOC)) {
				?>
					<div class="floor-container">
						<?php echo "Подъезд: ".$line_floor['number']." - "."Подъезд: ".$line_floor['entrance']; ?>
					</div>
				<?php
				}
			?>
		</div>
	</div>


<?php

	// Очистка результата
	pg_free_result($result_floor);

	// Закрытие соединения
	pg_close($dbc);

?>
	
</body>
</html>
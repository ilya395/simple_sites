<?php
require("../connect_bd.php");

$building_id = $_GET['building'];
$build_id = (int) $building_id;

//определяем этажность
$query_floor = "SELECT number, id FROM dj_floors WHERE building_id = '$build_id' ORDER BY number";
$result_floor = pg_query($query_floor) or die('Ошибка запроса: ' . pg_last_error());
var_dump($result_floor);

// массив для этажей
// for ($c = 1; $c <= count($result_floor); $c++) {

// }

$query_flats = "SELECT number, id, floor_id FROM dj_flats WHERE building_id = '$build_id'";
$result_flats = pg_query($query_flats) or die('Ошибка запроса: ' . pg_last_error());
var_dump($result_flats);
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

			<ul>
		<?php
			$line_floors_count = pg_num_rows($result_floor);
			$column_floors_fields = pg_num_fields($result_floor);
			echo $line_floors_count.', '.$column_floors_fields;

			for ($i = 1; $i < 8; $i++) {
		?>
				<li>
					<?php
						// $line_floors = pg_num_rows($result_floor); 
						// for ($j = 0; $j < $line_floors; $j++) {
						// 	if () {

						// 	}
						// }

						echo "Этаж: ".$i."<br>";

						$c_counter = 0;

						while ($line_floors = pg_fetch_array($result_floor, null, PGSQL_ASSOC)) {
							// var_dump($line_floors) ;
							// foreach ($line_floors as $col_value) {
							// 	echo $col_value.'; ';
							// }
							if ($line_floors['number'] == $i) {
								echo 'Подъезд: ' . $line_floors['id'] . ', ' . $line_floors['number'] . ';<br>';
								while ($line_flats = pg_fetch_array($result_flats, null, PGSQL_ASSOC)) {
									if ($line_flats['floor_id'] == $line_floors['id']) {
										echo $line_flats['number'].', '.$line_flats['floor_id'].'; ';
									}
								}
								echo '<br>';

							}

							// echo pg_num_fields($line_floors);
							
							// for ($c = 0; $c < count($line_floors); $c++) {
							// 	if ($line_floors['number'] == $i) {
							// 		$section_array[] = $line_floors['id'];
									
							// 		echo $section_array[].', '.$c_counter.'; ';
							// 	}
							// }
							
						}

						echo 'kek' . $i . '<br>';

						// while ($line_flats = pg_fetch_array($result_flats, null, PGSQL_ASSOC)) {
						// 	echo $line_flats['number'].', '.$line_flats['floor_id'].'; ';
						// 	$c_counter++;
						// }
						echo '<br>'.$c_counter;

						// pg_free_result($line_floors);
						// pg_free_result($line_flats);
					?>
				</li>
		<?php
			}
		?>
			</ul>

		</div>
	</div>


<?php

	// Очистка результата
	pg_free_result($result_floor);
	pg_free_result($result_flats);

	// Закрытие соединения
	pg_close($dbc);

?>
	
</body>
</html>
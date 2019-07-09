<?php
require("../connect_bd.php");

$building_id = $_GET['building'];
$build_id = (int) $building_id;

// определяем этажность
// Формируем запрос
$query_floor = "SELECT number, id FROM dj_floors WHERE building_id = '$build_id' ORDER BY number";
// Делаем запрос к БД, результат запроса пишем в $result_
$result_floor = pg_query($query_floor) or die('Ошибка запроса: ' . pg_last_error());
// Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data_floors = []; $row_floors = pg_fetch_array($result_floor, null, PGSQL_ASSOC); $data_floors[] = $row_floors);
// var_dump($result_floor);

// массив для этажей
// for ($c = 1; $c <= count($result_floor); $c++) {

// }

$query_flats = "SELECT number, id, floor_id FROM dj_flats WHERE building_id = '$build_id'";
$result_flats = pg_query($query_flats) or die('Ошибка запроса: ' . pg_last_error());
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data_flats = []; $row_flats = pg_fetch_assoc($result_flats); $data_flats[] = $row_flats);
// echo $result_flats;
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
			$a = count($data_floors);
			echo $a . '<br>';

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
							echo 'проверка номера этажа: ' . $line_floors['number'] . '<br>';

							if ($line_floors['number'] == $i) {
								echo 'Подъезд: ' . $line_floors['id'] . ', ' . $line_floors['number'] . ';<br>';
								// while ($line_flats = pg_fetch_array($result_flats, null, PGSQL_ASSOC)) {
								// 	if ($line_flats['floor_id'] == $line_floors['id']) {
								// 		echo $line_flats['number'].', '.$line_flats['floor_id'].'; ';
								// 	}
								// }
								$line_flats = pg_fetch_array($result_flats, null, PGSQL_ASSOC);
								var_dump($line_flats);
								echo count($line_flats);
								for ($k = 0; $k < count($line_flats); $k++) {
									if ($line_flats[$k]['floor_id'] == $line_floors['id']) {
										echo $line_flats[$k]['number'].', '.$line_flats[$k]['floor_id'].'; ';
									}
								}
								echo '<br>-----<br>';

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
						

						pg_free_result($line_floors);
						// pg_free_result($line_flats);
					?>
				</li>
		<?php
			}
		?>
			</ul>


		<?php
			print_r($data_floors);
			echo '<br><br>';
			print_r($data_flats);

			echo '<ul>';
				for ($i = 1; $i < 8; $i++) {
					echo '<li>';
						echo 'Этаж: ' . $i . '<br>';
						for ($j = 0; $j < count($data_floors); $j++) {
							if ($data_floors[$j]['number'] == $i) {
								echo $data_floors[$j]['number'] . ': ' . $data_floors[$j]['id'] . ', ';
								echo '<br>';
								for ($k = 0; $k < count($data_flats); $k++) {
									if ($data_flats[$k]['floor_id'] == $data_floors[$j]['id']) {
										echo $data_flats[$k]['number'] . ', ';

									}
								}
								echo '<br>';
							}
						}
					echo '</li>';
				}
			echo '</ul>';
			pg_free_result($result_floor);
			pg_free_result($result_flats);
		?>

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
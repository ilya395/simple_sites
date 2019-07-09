<?php
require("../connect_bd.php");

$building_id = $_GET['house-filter'];
$build_id = (int) $building_id;
// квартиры
$query_flats = "SELECT number, id, plan_id FROM dj_flats WHERE building_id = '$build_id' AND project_id = 44";
$result_flats = pg_query($query_flats) or die('Ошибка запроса: ' . pg_last_error());
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data_flats = []; $row_flats = pg_fetch_assoc($result_flats); $data_flats[] = $row_flats);
echo 'квартиры: ' . count($data_flats);

$rooming = $_GET['room-filter'];
$rooms_count = (int) $rooming;
// комнаты
if ($rooms_count != 0) {
	$query_plans = "SELECT id, rooms_count FROM dj_plans WHERE rooms_count = '$rooms_count' AND project_id = 44";
} else {
	$query_plans = "SELECT id, rooms_count FROM dj_plans WHERE project_id = 44";
}

$result_plans = pg_query($query_plans) or die('Ошибка запроса: ' . pg_last_error());
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data_plans = []; $row_plans = pg_fetch_assoc($result_plans); $data_plans[] = $row_plans);
echo 'планировки: ' . count($data_plans);


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Filter!</title>
</head>
<body>
	<div class="main-container">
		<div class="container">

			<form action="filter.php" method="GET" name="filter-form" class="main-filter">
				<p>
					<label for="roomFilter">количество комнат:</label>
					<select name="room-filter" id="roomFilter">
						<option disabled>Комнаты</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</p>
				<p>
					<label for="houseFilter">дом:</label>
					<select name="house-filter" id="houseFilter">
						<option value="96">1</option>
						<option value="97">2</option>
						<option value="98">3</option>
						<option value="99">4</option>
						<option value="100">5</option>
						<option value="101">6</option>
						<option value="102">7</option>
					</select>
				</p>
				<p>
					<input type="submit" value="Найти">
				</p>
			</form>

		<?php
			// print_r($data_plans);
			// echo '<br><br>';
			// print_r($data_flats);

			echo '<ul>';
				for ($k = 0; $k < count($data_flats); $k++) {
					
						
						for ($j = 0; $j < count($data_plans); $j++) {
							if ($data_plans[$j]['id'] == $data_flats[$k]['plan_id']) {
								echo '<li><a href="catalog.php/?building=' . $build_id . '" class="filter-flats-link">';
								echo 'квартира: ' . $data_flats[$k]['number'] . ' комнаты: ' . $data_plans[$j]['rooms_count'];
								echo '</a></li>';
							}
						}
					
				}
			echo '</ul>';

			// pg_free_result($result_floor);
			// pg_free_result($result_flats);
		?>

		</div>
	</div>

<?php

	// Очистка результата
	pg_free_result($result_plans);
	pg_free_result($result_flats);

	// Закрытие соединения
	pg_close($dbc);

?>
	
</body>
</html>
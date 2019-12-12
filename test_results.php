<?php

include_once('start_header.php');

include_once('db.php');



$query = $db->prepare("SELECT `subjects`.`name`, `user_selected_options`.`ball`, `subjects`.`amount` as `s_amount`, `user_selected_options`.`amount` as `uso_amount`, `user_selected_options`.`start_time` as `start_time`,`user_selected_options`.`fix_time` as `fix_time` FROM `subjects` LEFT JOIN `user_selected_options` ON `subjects`.`id` = `user_selected_options`.`subject_id` WHERE `user_selected_options`.`user_id` = :uid");

$query->bindValue(':uid', $_SESSION['logged_user']['id']);

$query->execute();

$test_results = $query->fetchAll();

// print_r($test_results);

date_default_timezone_set('UTC');

//$time_now = time() + (3 * 60 * 60);

?>

<section>

	<nav aria-label="breadcrumb">

		<ol class="breadcrumb">

			<li class="breadcrumb-item"><a href="index.php">Главная</a></li>

			<li class="breadcrumb-item active" aria-current="page">Результаты</li>

		</ol>

	</nav>



	<div class="section-test-results">

		<table class="table table-dark">

			<thead>

				<tr>

					<th scope="col">№</th>

					<th scope="col">Предмет</th>

					<th scope="col">Балл</th>

					<th scope="col">Верно</th>

					<th scope="col">Пройден за</th>

				</tr>

			</thead>

			<tbody>

			<?php $i=0; ?>

			<?php foreach ($test_results as $key => $value): ?>

				<!-- <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> -->

				<tr>

					<th scope="row"><?=($i+=1)?></th>

					<td><?=$value['name']?></td>

					<td><?=$value['ball']?></td>

					<td><?=$value['uso_amount']."/".$value['s_amount']?></td>

					<td><?=date('H:i:s', ($value['fix_time'] - $value['start_time']))?></td>

				</tr>

				<!-- </div> -->

			<?php endforeach ?>

		</tbody>

		</table>

	</div>



</section>

<?php

include_once('footer.php');

?>
<?php
include_once("aheader.php");

// echo "админка";

include_once('../db.php');
// include_once('../library.php');
date_default_timezone_set('UTC');


$query = $db->prepare("
	SELECT 
		`users`.`id` as `uid`,
		`users`.`firstname` as `firstname`,
		`users`.`lastname` as `lastname`,
		`users`.`middlename` as `middlename`,
		`users`.`username` as `username`,
		`users`.`phone` as `phone`,
		`users`.`email` as `email`,
		`users`.`institution` as `institution`,
		`subjects`.`id` as `sid`, 
		`subjects`.`name` as `sname`, 
		`user_selected_options`.`ball` as `ball`, 
		`subjects`.`amount` as `s_amount`, 
		`user_selected_options`.`amount` as `uso_amount`, 
		`user_selected_options`.`start_time` as `start_time`,
		`user_selected_options`.`fix_time` as `fix_time`
	FROM `user_selected_options` 
	LEFT JOIN `subjects` ON (`subjects`.`id` = `user_selected_options`.`subject_id`)
	LEFT JOIN `users` ON (`users`.`id` = `user_selected_options`.`user_id`)
");

// $query->bindValue(':uid', $_SESSION['logged_user']['id']);

$query->execute();
$test_results = $query->fetchAll();
?>

<div class="modal fade" id="showApelationModal" tabindex="-1" role="dialog" aria-labelledby="showApelationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showApelationModalLabel">Апелляция
			<span class="badge badge-secondary">0</span>
			<span class="badge badge-primary">0</span>
			<span class="badge badge-success">0</span>
			<span class="badge badge-danger">0</span>
		</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-body apelation-result">
	  	<!-- <div class="apelation-result"></div>		 -->
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Записать</button>
      </div> -->
    </div>
  </div>
</div>

<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xs-12">
		<div class="res-table-message"></div>
		<div id="table-user-result" class="table-responsive mCustomScrollbar" data-mcs-axis="" data-mcs-theme="">
			<table id="all-results-table" class="table table-dark tablesorter">
				<thead>
					<tr>
						<th scope="col" class="" data-placeholder="Введите номер">№</th>
						<th scope="col" class="filter-match" data-placeholder="Введите логин">Пользователь</th>
						<th scope="col" class="filter-match" data-placeholder="Введите фамилию">Фамилия</th>
						<th scope="col" class="filter-match" data-placeholder="Введите имя">Имя</th>
						<th scope="col" class="filter-match" data-placeholder="Введите учебное заведение">Учеб.зав</th>
						<th scope="col" class="" data-placeholder="Введите телефон">Телефон</th>
						<th scope="col" class="" data-placeholder="Введите почту">Почта</th>
						<th scope="col" class="filter-select" data-placeholder="Выберите олимпиаду">Предмет</th>
						<th scope="col" class="filter-select" data-placeholder="Выберите балл">Балл</th>
						<th scope="col" class="" data-placeholder="Введите количество">Верно</th>
						<th scope="col" class="" data-placeholder="Введите время">Пройден за</th>
						<th scope="col" class="" data-placeholder="">Удалить</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; ?>
				<?php foreach ($test_results as $key => $value): ?>
					<!-- <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> -->
					<tr>
						<th scope="row"><?=($i+=1)?></th>
						<td><?=$value['username']?></td>
						<td><?=$value['firstname']?></td>
						<td><?=$value['lastname']?></td>
						<td><?=$value['institution']?></td>
						<td><?=$value['phone']?></td>
						<td><?=$value['email']?></td>
						<td><?=$value['sname']?></td>
						<td><?=$value['ball']?></td>
						<td><?=$value['uso_amount']."/".$value['s_amount']?></td>
						<td><?=date('H:i:s', $value['fix_time'] - $value['start_time'])?></td>
						<!-- <td class="table-row-act"><span class="user-result-delete" data-su="<?=$value['uid']?>-<?=$value['sid']?>"><i class="fa fa-trash"></i></span></td> -->
						<td class="table-row-act">
							<div class="dropdown">
								<a class="subject-dropdown-menu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-cog"></i>
								</a>

								<div class="dropdown-menu" data-sid="<?=$value['sid']?>" data-uid="<?=$value['uid']?>">
									<a class="dropdown-item show-apelation" data-toggle="modal" data-target="#showApelationModal" href="#">Апелляция</a>
									<!-- <a class="dropdown-item" href="#"> -->
									<!-- <span class="dropdown-item user-result-delete" data-su="<?=$value['uid']?>-<?=$value['sid']?>"> -->
										<!-- <i class="fa fa-trash"></i> -->
									<!-- </span> -->
									<a class="dropdown-item delete-user-result" href="#" data-su="<?=$value['uid']?>-<?=$value['sid']?>">Удалить</a>
									<!-- <a class="dropdown-item" href="#"></a> -->
								</div>
							</div>
						</td>
					</tr>
					<!-- </div> -->
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xs-6">
		
	</div> -->
</div>

<?php
include_once("afooter.php");
?>
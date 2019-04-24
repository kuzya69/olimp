<?php
include_once("aheader.php");
include_once('../db.php');
include_once("../library.php");

$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
$test_results = getSubjects($db, $user_information);

// print_r($test_results);

?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newSubjectModal">Open modal for @mdo</button>
<div class="res-table-message"></div>
<div class="modal fade" id="newSubjectModal" tabindex="-1" role="dialog" aria-labelledby="newSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubjectModalLabel">Создание новой олимпиады</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">
				<form action="add_subject.php" method="POST"  class="form-create-subject">
					<!-- <h1 class="h3 mb-3 font-weight-normal">Форма создания олимпиады</h1> -->
					<div class="form-group">
						<label for="inputCreateName" class="col-form-label">Название</label>
						<input type="text" id="inputCreateName" class="form-control" placeholder="Введите название" required="" autofocus="" name="name" value="">
					</div>
					<div class="form-group">
						<label for="inputCreateDescription" class="col-form-label">Описание</label>
						<textarea id="inputCreateDescription" class="form-control" placeholder="Введите описание" required="" autofocus="" name="description" value="" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label for="inputCreateTime" class="col-form-label">Время</label>
						<input type="number" id="inputCreateTime" class="form-control" placeholder="Время на олимпиаду(мин.)" required="" name="time">
					</div>
					<div class="form-group">
						<label for="inputCreateAmount" class="col-form-label">Количество вопросов</label>
						<input type="number" id="inputCreateAmount" class="form-control" placeholder="Введите количество вопросов" required="" name="amount">
					</div>
					<div class="form-group">
						<label for="inputCreateDateStart" class="col-form-label">Начало</label>
						<input type="date" id="inputCreateDateStart" class="form-control" placeholder="дата начала" required="" name="date_start" value="">
					</div>
					<div class="form-group">
						<label for="inputCreateDateEnd" class="col-form-label">Конец</label>
						<input type="date" id="inputCreateDateEnd" class="form-control" placeholder="дата конца" required="" name="date_end" value="">
					</div>

					<input id="create-subject-submit" type="button" class="btn btn-lg btn-primary btn-block" name="create-subject-submit" value="Записать">
				</form>
			</div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Записать</button>
      </div> -->
    </div>
  </div>
</div>

<div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubjectModalLabel">Резактирование олимпиады</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">
				<form action="" method="POST"  class="form-edit-subject">
					<!-- <h1 class="h3 mb-3 font-weight-normal">Форма создания олимпиады</h1> -->
					<div class="form-group">
						<label for="inputEditName" class="col-form-label">Название</label>
						<input type="text" id="inputEditName" class="form-control" placeholder="Введите название" autofocus="" name="name" value="">
					</div>
					<div class="form-group">
						<label for="inputEditDescription" class="col-form-label">Описание</label>
						<textarea id="inputEditDescription" class="form-control" placeholder="Введите описание" autofocus="" name="description" value="" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label for="inputEditTime" class="col-form-label">Время</label>
						<input type="number" id="inputEditTime" class="form-control" placeholder="Время на олимпиаду(мин.)" name="time" value="">
					</div>
					<div class="form-group">
						<label for="inputEditAmount" class="col-form-label">Количество вопросов</label>
						<input type="number" id="inputEditAmount" class="form-control" placeholder="Введите количество вопросов" name="amount" value="">
					</div>
					<div class="form-group">
						<label for="inputEditDateStart" class="col-form-label">Начало</label>
						<input type="date" id="inputEditDateStart" class="form-control" placeholder="дата начала" name="date_start" value="">
					</div>
					<div class="form-group">
						<label for="inputEditDateEnd" class="col-form-label">Конец</label>
						<input type="date" id="inputEditDateEnd" class="form-control" placeholder="дата конца" name="date_end" value="">
					</div>
					<input id="edit-subject-submit" type="button" class="btn btn-lg btn-primary btn-block" data-id="" name="edit-subject-submit" value="Записать">
				</form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Записать</button>
      </div> -->
    </div>
  </div>
</div>

<section>
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xs-12">
			
			<br>
			<div id="table-subjects-information" class="table-responsive mCustomScrollbar" data-mcs-axis="" data-mcs-theme="">
				<table id="all-subjects-table" class="table table-dark tablesort">
					<thead>
						<tr>
							<th scope="col" class="filter-match" data-placeholder="Введите номер">№</th>
							<th scope="col" class="filter-select" data-placeholder="Выберите название">Название предмета</th>
							<th scope="col" class="filter-select" data-placeholder="Выберите минуты">Минут</th>
							<th scope="col" class="filter-select" data-placeholder="Выберите количество вопросов">Вопросов</th>
							<th scope="col" class="filter-match" data-placeholder="Введите дату начало">Начало</th>
							<th scope="col" class="filter-match" data-placeholder="Введите дату конца">Конец</th>
							<th scope="col">Действие</th>
						</tr>
					</thead>
					<tbody>
					<?php $i=0; ?>
					<?php foreach ($test_results as $key => $value): ?>
						<!-- <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> -->
						<?php if($value['display'] == 0):?>
						<tr class = "subject_unvis">
						<?php else:?>
						<tr>
						<?php endif;?>
							<th scope="row"><?=($i+=1)?></th>
							<td><?=$value['name']?></td>
							<td><?=$value['time']?></td>
							<td><?=$value['amount']?></td>
							<td><?=$value['date_start']?></td>
							<td><?=$value['date_end']?></td>
							<td class="table-row-act">
								<div class="dropdown">
									<a class="subject-dropdown-menu" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-cog"></i>
									</a>

									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-sid="<?=$value['id']?>">
										<a class="dropdown-item subject-edit" data-toggle="modal" data-target="#editSubjectModal" href="#">Редактировать</a>
										<?php if($value['display'] == 0):?>
										<a class="dropdown-item subject-delete" data-vis=1 href="#">Показать</a>
										<?php else:?>
										<a class="dropdown-item subject-delete" data-vis=0 href="#">Скрыть</a>
										<?php endif;?>
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
</section>
<?php

include_once("afooter.php");
?>
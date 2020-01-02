<?php
include_once("aheader.php");
include_once('../db.php');
include_once("../library.php");

$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
// $test_results = getQuestionsBySubject($db, $sid, $user_information);
$subjects = getSubjects($db, []);

// echo "Добавление вопросов";
// $list = array (
//     array('aaa', 'bbb', 'ccc', 'dddd'),
//     array('123', '456', '789'),
//     array('"aaa"', '"bbb"')
// );

// $fp = fopen('../temporary/file.csv', 'w');

// foreach ($list as $fields) {
//     fputcsv($fp, $fields, ";");
// }

// fclose($fp);
?>
<div class="modal fade" id="newQuestionModal" tabindex="-1" role="dialog" aria-labelledby="newQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newQuestionModalLabel">Добавить вопрос</h5><span id="createQuestionLoadSuccess"><img src="../icon/peace.png"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body modal-create">
			<form action="upload_images.php" method="POST" class="form-create-question-image" id="formCreateQuestionImage" enctype="multipart/form-data">
					<!-- <h1 class="h3 mb-3 font-weight-normal">Форма создания олимпиады</h1> -->
					<div class="form-group" id="question-create-image-preview">
							<input type="hidden" name="sid" value="" />
							<input type="hidden" name="qid" value="" />
							<input type="hidden" name="type" value="" />
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
							<!--Название элемента input определяет имя в массиве $_FILES--> 
							<label class="question-create-image-label" for="question-image">Загрузить картинку</label>
							<input class="question-create-image-input" name="question-create-image" id="question-create-image-input" type="file" lang="ru" accept="image/*"/>
					</div>
					<input id="create-question-submit" type="submit" class="btn btn-lg btn-primary btn-block" data-id="" name="create-question-submit" value="Записать">
				</form>
				<form action="add_question.php" method="POST"  class="form-create-question">
					<div class="form-group">
						<label for="inputCreateQuestion" class="col-form-label">Вопрос</label>
						<textarea id="inputCreateQuestion" class="form-control" placeholder="Введите вопрос" autofocus="" name="question" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputCreateOptionType1" type="checkbox" name="create-type:1">
							</div>
						</div>
						<textarea id="inputCreateOption1" class="form-control" placeholder="Введите ответ" autofocus="" name="option_1" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputCreateOptionType2" type="checkbox" name="create-type:2">
							</div>
						</div>
						<textarea id="inputCreateOption2" class="form-control" placeholder="Введите ответ" autofocus="" name="option_2" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputCreateOptionType3" type="checkbox" name="create-type:3">
							</div>
						</div>
						<textarea id="inputCreateOption3" class="form-control" placeholder="Введите ответ" autofocus="" name="option_3" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputCreateOptionType4" type="checkbox" name="create-type:4">
							</div>
						</div>
						<textarea id="inputCreateOption4" class="form-control" placeholder="Введите ответ" autofocus="" name="option_4" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputCreateOptionType5" type="checkbox" name="create-type:5">
							</div>
						</div>
						<textarea id="inputCreateOption5" class="form-control" placeholder="Введите ответ" autofocus="" name="option_5" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputCreateOptionType6" type="checkbox" name="create-type:6">
							</div>
						</div>
						<textarea id="inputCreateOption6" class="form-control" placeholder="Введите ответ" autofocus="" name="option_6" value="" rows="1"></textarea>
					</div>

					<!-- <input id="create-question-submit" type="button" class="btn btn-lg btn-primary btn-block" name="create-question-submit" value="Записать"> -->
				</form>
			</div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Записать</button>
      </div> -->
    </div>
  </div>
</div>

<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editQuestionModalLabel">Редактировать вопрос</h5><span id="editQuestionLoadSuccess"><img src="../icon/peace.png"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body modal-edit">
				<form action="upload_images.php" method="POST" class="form-edit-question-image" id="formEditQuestionImage" enctype="multipart/form-data">
					<!-- <h1 class="h3 mb-3 font-weight-normal">Форма создания олимпиады</h1> -->
					<div class="form-group" id="question-edit-image-preview">
							<input type="hidden" name="sid" value="" />
							<input type="hidden" name="qid" value="" />
							<input type="hidden" name="type" value="" />
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
							<!--Название элемента input определяет имя в массиве $_FILES--> 
							<label class="question-edit-image-label" for="question-image">Загрузить картинку</label>
							<input class="question-edit-image-input" name="question-edit-image" id="question-edit-image-input" type="file" lang="ru" accept="image/*"/>
					</div>
					<input id="edit-question-submit" type="submit" class="btn btn-lg btn-primary btn-block" data-id="" name="edit-question-submit" value="Записать">
				</form>	
				<form action="" method="POST" class="form-edit-question" enctype="multipart/form-data">
					<div class="form-group">
						<label for="inputEditQuestion" class="col-form-label">Вопрос</label>
						<textarea id="inputEditQuestion" class="form-control" placeholder="Введите вопрос" autofocus="" name="question" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputUpdateOptionType1" type="checkbox" name="update-type:1">
							</div>
						</div>
						<textarea id="inputEditOption1" class="form-control" placeholder="Введите ответ" autofocus="" name="option_1" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputUpdateOptionType2" type="checkbox" name="update-type:2">
							</div>
						</div>
						<textarea id="inputEditOption2" class="form-control" placeholder="Введите ответ" autofocus="" name="option_2" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputUpdateOptionType3" type="checkbox" name="update-type:3">
							</div>
						</div>
						<textarea id="inputEditOption3" class="form-control" placeholder="Введите ответ" autofocus="" name="option_3" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputUpdateOptionType4" type="checkbox" name="update-type:4">
							</div>
						</div>
						<textarea id="inputEditOption4" class="form-control" placeholder="Введите ответ" autofocus="" name="option_4" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputUpdateOptionType5" type="checkbox" name="update-type:5">
							</div>
						</div>
						<textarea id="inputEditOption5" class="form-control" placeholder="Введите ответ" autofocus="" name="option_5" value="" rows="1"></textarea>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<input id="inputUpdateOptionType6" type="checkbox" name="update-type:6">
							</div>
						</div>
						<textarea id="inputEditOption6" class="form-control" placeholder="Введите ответ" autofocus="" name="option_6" value="" rows="1"></textarea>
					</div>
					<!-- <input id="edit-question-submit" type="button" class="btn btn-lg btn-primary btn-block" data-id="" name="edit-question-submit" value="Записать"> -->
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
	<div class="row my-row">
			<div class="col-12 my-col">
					<select class="form-control select-subject" id="select-subject">
							<option selected value="0">Выберите олимпиаду</option>
							<?php foreach($subjects as $key=>$value){?>
									<option value="<?=$value['id']?>"><?=$value['name']?></option>
							<?php } ?>
					</select>
			</div>
			<div class="col-6 my-col col-new-quest-butt">
					<button type="button" class="btn btn-primary new-question-button" data-toggle="modal" data-target="#newQuestionModal">Добавить вопрос</button>
			</div>
			<div class="col-6 my-col col-down-quest-butt">
					<button type="button" class="btn btn-primary download-questions-button" data-toggle="modal" data-target="#downloadQuestionsModal">Загрузить вопросы</button>
			</div>
	</div>
	<div class="res-table-message"></div>
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xs-12">
			<div id="table-questions-information" class="table-responsive mCustomScrollbar" data-mcs-axis="" data-mcs-theme="">
				<table id="questions-table-by-subject" class="table table-dark tablesorter">
					<thead>
						<tr>
							<th scope="col" data-placeholder="Введите номер">№</th>
							<th scope="col" data-placeholder="">Картинка</th>
							<th scope="col" class="filter-match" data-placeholder="Введите вопрос">Вопрос</th>
							<th scope="col" class="filter-match" data-placeholder="Введите ответ">Ответ</th>
							<th scope="col" class="filter-match" data-placeholder="Введите ответ">Ответ</th>
							<th scope="col" class="filter-match" data-placeholder="Введите ответ">Ответ</th>
							<th scope="col" class="filter-match" data-placeholder="Введите ответ">Ответ</th>
							<th scope="col" class="filter-match" data-placeholder="Введите ответ">Ответ</th>
							<th scope="col" class="filter-match" data-placeholder="Введите ответ">Ответ</th>
							<th scope="col">Действие</th>
						</tr>
					</thead>
					<tbody>
						<!-- <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> -->
						<!-- <tr>
                            <th>1</th>
                            <td><img src="../images/marvel/marvel_1.jpg" alt="" width="100px"></td>
                            <td>asasdasddasdasdasdasdasdasdasd?</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td class="table-row-act">
								<div class="dropdown">
									<a class="question-dropdown-menu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-cog"></i>
									</a>
									<div class="dropdown-menu" data-sid="<?//=$value['sid']?>">
										<a class="dropdown-item question-edit" data-toggle="modal" data-target="#editQuestionModal" href="#">Редактировать</a>
										<a class="dropdown-item question-delete" href="#">Удалить</a>
									</div>
								</div>
							</td>
                        </tr> -->
						<!-- </div> -->
					</tbody>
				</table>
			</div>
		</div>
		<!-- <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xs-6">
			
		</div> -->
    </div>
</section>
<!-- <div class="form-group"> -->
    <!-- <label for="selectSubject">Выбрать предмет</label> -->
<!-- </div> -->
<?php
// $row = 1;
// if (($handle = fopen("../temporary/file.csv", "r")) !== FALSE) {
//     while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
//         $num = count($data);
//         echo "<p> $num полей в строке $row: <br /></p>\n";
//         $row++;
//         for ($c=0; $c < $num; $c++) {
//             echo $data[$c] . "<br />\n";
//         }
//     }
//     fclose($handle);
// }

include_once("afooter.php");
?>
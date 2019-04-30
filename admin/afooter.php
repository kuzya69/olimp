	
		<!-- <div class="_link-footer">
				<div id="annotation" title="Аннотация">
					<h2>Аннотация</h2>
					<p>Подготовленный нами лабораторный практикум по дисциплине «Операционные системы среды и оболочки» предназначен для студентов специальности Прикладная информатика, но может быть использовано и при преподавании других дисциплин специальности ПИ.</p>
					<p>Предлагаемый лабораторный практикум включает все виды учебно-методических материалов: для лекционных и практических (лабораторных) занятий, вопросы для контроля, тестовые наборы, список учебной и хрестоматийной (дополнительной) литературы и др.</p>
					<figure class="image">
						<img src="images/7.png" alt="Картинка">
						<figcaption>
							
						</figcaption>
					</figure>
				</div>
		</div> -->
		<!-- <script src="lib/jquery-ui-1.12.1/external/jquery/jquery.js"></script> -->
		<script src="../lib/jquery_3.3.1.min.js"></script>
		<script src="scripts/tablesorter.js"></script>
		<script src="scripts/tablesorter-widget-filter.js"></script>
		<!-- <script src="scripts/tablesorter-parser-input-select.js"></script> -->

		<!-- <script src="lib/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script> -->
		<script src="../lib/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
		<!-- <script src="../lib/bootstrap-4.3.1-dist/js/popper.min.js"></script> -->
		<!-- <script src="lib/jquery-ui-1.12.1/jquery-ui.min.js"></script> -->
		<script src="../lib/jquery-content-scroller/js/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="scripts/uploadPreview.min.js"></script>
		<script src="../scripts/script_one.js"></script>
		<!-- <script src="../scripts/script_two.js"></script> -->
		<!-- <script src="../scripts/script_tabs.js"></script> -->
		<!-- <script src="../scripts/script_test.js"></script> -->
		
		<script>
			//Нижний скрол для талицы
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
				$("#table-user-result").removeClass("mCustomScrollbar");
				$("#table-subjects-information").removeClass("mCustomScrollbar");
			}else{
				$("#table-user-result").mCustomScrollbar({
					axis:"x",
					mouseWheel: {
						// enable: true,
						scrollAmount: 400,
						// axis: "x",
						// preventDefault: true,
						// deltaFactor: 10000,
					},
				});

				$("#table-subjects-information").mCustomScrollbar({
					axis:"x",
					mouseWheel: {
						// enable: true,
						scrollAmount: 400,
						// axis: "x",
						// preventDefault: true,
						// deltaFactor: 10000,
					},
				});

				$("#table-questions-information").mCustomScrollbar({
					axis:"x",
					mouseWheel: {
						// enable: true,
						scrollAmount: 400,
						// axis: "x",
						// preventDefault: true,
						// deltaFactor: 10000,
					},
				});
			}
			// (function($){
			// 	$(window).on("load",function(){
			// 		$(".table-responsive").mCustomScrollbar({
			// 			mouseWheel: {
			// 				enable: true,
			// 				scrollAmount: 1000,
			// 				axis: "x",
			// 				preventDefault: false,
			// 				deltaFactor: 1000,
			// 			},
			// 		});
			// 	});
			// })(jQuery);

			// (function($){
				// $(window).on("load",function(){

					//Добавление фильтрации
					$("#all-results-table").tablesorter({
						// hidden filter input/selects will resize the columns, so try to minimize the change
						// theme:'blue',
						widthFixed : true,


						headers: {
							// 0: { sorter: "select", filter: "parsed" },
							// 1: { sorter: "select", filter: "parsed" },
							// 2: { sorter: true, filter: false },
							// 3: { sorter: "input", filter: "parsed" },
							// 4: { sorter: "input", filter: "parsed" },
							// 5: { sorter: "input", filter: "parsed" },
							// 6: { sorter: "input", filter: "parsed" },
							// 7: { sorter: "input", filter: "parsed" },
							// 8: { sorter: "input", filter: "parsed" },
							// 9: { sorter: "input", filter: "parsed" },
							11: { sorter: false, filter: false }
						},
						widgets: [ "columns", "filter", "zebra" ],

						widgetOptions : {
							// extra css class applied to the table row containing the filters & the inputs within that row
							filter_cssFilter   : '',

							// If there are child rows in the table (rows with class name from "cssChildRow" option)
							// and this option is true and a match is found anywhere in the child row, then it will make that row
							// visible; default is false
							filter_childRows   : false,

							// if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
							// below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
							filter_hideFilters : false,

							// Set this option to false to make the searches case sensitive
							filter_ignoreCase  : true,

							// jQuery selector string of an element used to reset the filters
							// filter_reset : '.reset',

							// Use the $.tablesorter.storage utility to save the most recent filters
							// filter_saveFilters : true,

							// Delay in milliseconds before the filter widget starts searching; This option prevents searching for
							// every character while typing and should make searching large tables faster.
							// filter_searchDelay : 300,

							// Set this option to true to use the filter to find text from the start of the column
							// So typing in "a" will find "albert" but not "frank", both have a's; default is false
							// filter_startsWith  : false,

							filter_searchFiltered : false,

							// Add select box to 4th column (zero-based index)
							// each option has an associated function that returns a boolean
							// function variables:
							// e = exact text from cell
							// n = normalized value returned by the column parser
							// f = search filter input value
							// i = column index
							filter_functions : {
							// 	// Add select menu to this column
							// 	// set the column value to true, and/or add "filter-select" class name to header
							// 	// '.first-name' : true,
							// 	// Exact match only
								// 1 : function(e, n, f, i, $r, c, data) {
								// return e === f;
								// },

							}
						},
					});
					
					//Добавление фильтарации
					$("#all-subjects-table").tablesorter({
						widthFixed : true,
						widgets: [ "columns", "filter", "zebra" ],
						headers: {
							6: { sorter: false, filter: false }
						},
						widgetOptions : {
							filter_cssFilter   : '',
							filter_childRows   : false,
							filter_hideFilters : false,
							filter_ignoreCase  : true,
							filter_searchFiltered : false,
							filter_functions : {

							}
						},
					});

					//Добавление фильтарации
					$("#questions-table-by-subject").tablesorter({
						widthFixed : true,
						widgets: [ "columns", "filter", "zebra" ],
						headers: {
							0: { sorter: true, filter: false },
							1: { sorter: false, filter: false },
							9: { sorter: false, filter: false }
						},
						widgetOptions : {
							filter_cssFilter   : '',
							filter_childRows   : false,
							filter_hideFilters : false,
							filter_ignoreCase  : true,
							filter_searchFiltered : false,
							filter_functions : {

							}
						},
					});

				// });
			// })(jQuery);

			//Удалить результат пользователя
			$(".user-result-delete").on("click", function(){
				var thisElement = $(this);
				var dataSu = $(this).data("su").split("-");
				var ans = confirm("Вы уверены что хотите безвозвратно удалить данные о результатах теста этого пользователя?");
				// alert(ans);
				if(ans === true){
					$.ajax({
						type: "POST",
						data: {status: 0, u: dataSu[0], s: dataSu[1]},
						url: "a_ajax_request.php",
						dataType : "json",   
						success: function(data){
							$(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
							if(data['status'] == 1){
								thisElement.parent().parent().remove();
							}
						},
					});
				}
			});

			//Действие над предметом
			$(".subject-edit").on('click', function(){
				var sid = $(this).parent().data('sid');
				$.ajax({
					type: "POST",
					data: {status: 11, s: sid},
					url: "a_ajax_request.php",
					dataType : "json",   
					success: function(data){
						// $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						document.getElementById('inputEditName').value = data['name'];
						document.getElementById('inputEditDescription').value = data['description'];
						document.getElementById('inputEditTime').value = data['time'];
						document.getElementById('inputEditAmount').value = data['amount'];
						document.getElementById('inputEditDateStart').value = data['date_start'];
						document.getElementById('inputEditDateEnd').value = data['date_end'];
						$('#edit-subject-submit').data('id', sid);
						// if(data['status'] == 1){
							// thisElement.parent().parent().remove();
						// }
					},
				});
			});

			$("#all-subjects-table").on('click', '.subject-delete', function(){
				var thisElem = $(this);
				var sid = $(this).parent().data('sid');
				var vis = $(this).data('vis');
				$.ajax({
					type: "POST",
					data: {status: 10, s: sid, d: vis},
					url: "a_ajax_request.php",
					dataType : "json",   
					success: function(data){
						$(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						if(vis == 1){
							// alert(thisElem.parent().parent().tagName);
							thisElem.parent().parent().parent().parent().removeClass("subject_unvis");
							thisElem.data('vis', 0);
							thisElem.text("Скрыть");
						}else{
							// alert(thisElem.parent().parent().tagName);
							thisElem.parent().parent().parent().parent().addClass("subject_unvis");
							thisElem.data('vis', 1);
							thisElem.text("Показать");
						}
						// if(data['status'] == 1){
							// thisElement.parent().parent().remove();
						// }
					},
				});
			});

			$('#edit-subject-submit').on('click', function(){
				var sid = $(this).data('id');
				var formData = $('.form-edit-subject').serializeArray();
				var tableRow = $('div[data-sid="'+sid+'"]').parent().parent().parent();
				// console.log(tableRow.find('td:eq( 0 )').text());
				var fData = [];
				$.each(formData, function(index, value){
					fData[value['name']] = value['value'];
				});
				$.ajax({
					type: "POST",
					data: {status: 12, s: sid, fd: formData},
					url: "a_ajax_request.php",
					dataType : "json",   
					success: function(data){
						$(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						// if(data['status'] == 1){
							// thisElement.parent().parent().remove();
						// }
						if(data['status'] === 1){
							// tableRow.find('td').each(function(index, value){
							// 	console.log(value);
							// });
							tableRow.find('td:eq( 0 )').text(fData['name']);
							// tableRow.find('td:eq( 1 )').text(fData['description']);
							tableRow.find('td:eq( 1 )').text(fData['time']);
							tableRow.find('td:eq( 2 )').text(fData['amount']);
							tableRow.find('td:eq( 3 )').text(fData['date_start']);
							tableRow.find('td:eq( 4 )').text(fData['date_end']);
						}
					},
				});
				// $.each(formData, function(index, value){
				// 	console.log(value['name']+"-"+value['value']);
				// });
			});

			$('#create-subject-submit').on('click', function(){
				var formData = $('.form-create-subject').serializeArray();
				if($(".form-create-subject")[0].checkValidity()) {
					$.ajax({
						type: "POST",
						data: {status: 13, fd: formData},
						url: "a_ajax_request.php",
						dataType : "json",   
						success: function(data){
							$(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						},
					});
				}else {
					console.log("invalid form")
				};
				// var fData = [];
				// $.each(formData, function(index, value){
				// 	fData[value['name']] = value['value'];
				// });
				// console.log(fData);

				// e.preventDefault();
				// var $form = $('.form-create-subject');

				// check if the input is valid
				// if(! $form.valid()) return false;
			});

			//Действия над вопросами
			$('#select-subject').on('change', function(){
				var sid = $(this).val();
				// var sname = $(this).find("option:selected").text();
				// console.log(sname);
				var tableRow = $('#questions-table-by-subject tbody');
				$.ajax({
					type: "POST",
					data: {status: 21, s: sid},
					url: "a_ajax_request.php",
					dataType: "json",
					success: function(data){
						tableRow.html("");
						var countQuestion = 0;
						data.forEach(function(item){
							tableRow.append('<tr>'
								+'<th>'+(++countQuestion)+'</th>'
								+'<td><img src="../'+item['question_img']+'" alt="" width="100px"></td>'
								+'<td>'+item['question']+'</td>'
								+'<td>'+item['option_1']+'</td>'
								+'<td>'+item['option_2']+'</td>'
								+'<td>'+item['option_3']+'</td>'
								+'<td>'+item['option_4']+'</td>'
								+'<td>'+item['option_5']+'</td>'
								+'<td>'+item['option_6']+'</td>'
								+'<td class="table-row-act">'
									+'<div class="dropdown">'
										+'<a class="question-dropdown-menu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
											+'<i class="fa fa-cog"></i>'
										+'</a>'
										+'<div class="dropdown-menu" data-qid="'+item['id']+'">'
											+'<a class="dropdown-item question-edit" data-toggle="modal" data-target="#editQuestionModal" href="#">Редактировать</a>'
											+'<a class="dropdown-item question-delete" href="#">Удалить</a>'
										+'</div>'
									+'</div>'
								+'</td>'
							+'</tr>');
							// console.log(item['question']);
						});
						
						//Обновить сортировку
						$("#questions-table-by-subject").trigger('update');
					}
				});

				// if(sid == 0){
				// 	$('.new-question-button').data('target', '');
				// 	alert($('.new-question-button').data('target'));
				// }else{
				// 	$('.new-question-button').data('target', '#newQuestionModal');
				// 	alert($('.new-question-button').data('target'));
				// }
			});

			//Действие над предметом
			$("#questions-table-by-subject").on('click', '.question-edit', function(){
				var qid = $(this).parent().data('qid');
				$.ajax({
					type: "POST",
					data: {status: 22, q: qid},
					url: "a_ajax_request.php",
					dataType : "json",   
					success: function(data){
						console.log(data);
						// $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						if(data['question_img'] !== null && data['question_img'] !== "" && data['question_img']){
							document.getElementById('question-edit-image-preview').style.backgroundImage = "url(../"+data['question_img']+")";
							document.getElementById('question-edit-image-preview').style.backgroundSize = "contain";
							document.getElementById('question-edit-image-preview').style.backgroundPosition = "center center";
							document.getElementById('question-edit-image-input').value = "";
						}else{
							document.getElementById('question-edit-image-preview').style.backgroundImage = "none";
							document.getElementById('question-edit-image-input').value = "";
						}
						document.getElementById('inputEditQuestion').value = data['question'];
						document.getElementById('inputEditOption1').value = (data['option_1'])?data['option_1']:"";
						document.getElementById('inputEditOption2').value = (data['option_2'])?data['option_2']:"";
						document.getElementById('inputEditOption3').value = (data['option_3'])?data['option_3']:"";
						document.getElementById('inputEditOption4').value = (data['option_4'])?data['option_4']:"";
						document.getElementById('inputEditOption5').value = (data['option_5'])?data['option_5']:"";
						document.getElementById('inputEditOption6').value = (data['option_6'])?data['option_6']:"";
						$('#edit-question-submit').data('id', qid);
						// if(data['status'] == 1){
							// thisElement.parent().parent().remove();
						// }
					},
				});
			});

			// При нажатии на создание нового вопроса картинка, если есть, сбрасывается 
			$('.new-question-button').on('click', function(){
				document.getElementById('question-create-image-preview').style.backgroundImage = "none";
				document.getElementById('question-create-image-input').value = "";
			});


			// $(document).ready(function() {
				$.uploadPreview({
					input_field: "#question-edit-image-input",   // По умолчанию: .image-upload
					preview_box: "#question-edit-image-preview",  // По умолчанию: .image-preview
					label_field: ".question-edit-image-label",    // По умолчанию: .image-label
					label_default: "Выбрать картинку",   // По умолчанию: Choose File
					label_selected: "Изменить картинку",  // По умолчанию: Change File
					no_label: false,                // По умолчанию: false
					success_callback: null          // По умолчанию: null
					// input_field: ".question-image-input",
					// preview_box: ".question-image-preview",
					// label_field: ".question-image-label"
				});

				$.uploadPreview({
					input_field: "#question-create-image-input",   // По умолчанию: .image-upload
					preview_box: "#question-create-image-preview",  // По умолчанию: .image-preview
					label_field: ".question-create-image-label",    // По умолчанию: .image-label
					label_default: "Выбрать картинку",   // По умолчанию: Choose File
					label_selected: "Изменить картинку",  // По умолчанию: Change File
					no_label: false,                // По умолчанию: false
					success_callback: null          // По умолчанию: null
					// input_field: ".question-image-input",
					// preview_box: ".question-image-preview",
					// label_field: ".question-image-label"
				});
			// });

		</script>
		<footer>
			<!-- <div class="footer">
				<div class="f_block">
					<ul>
						<li class="li_first">Автор:</li>
						<li>ст-т(ка) 3 курса</li>
						<li>специальности ПИЭ</li>
						<li>Курбанова</li>
						<li>Фаина Ф.</li>
						<li>kurbanovafaina@gmail.com</li>
					</ul>
				</div>
				<div class="f_block f_block_2">
					<ul>
						<li class="li_first">Руководитель:</li>
						<li>к.э.н. доцент</li>
						<li>ФИиИТ ДГУ</li>
						<li>Гаджиев</li>
						<li>Насрулла К.</li>
						<li>n_gadzhiev@mail.ru</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div> -->
			<!-- <div class="_made_date"> -->
				<?php
				// if(date('Y') != '2019'){
				// 	echo "© 2019 - ".date('Y')." Copyright: DSTU";
				// }
				// else{
				// 	echo "© 2019 Copyright: DSTU"; 
				// }
				?>

			<!-- </div> -->
		</footer>
	</div> <!--закрывающийся тег контаинера-->
</body>
</html>
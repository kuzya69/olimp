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

function printMessage(destination, msg) {
    $(destination).removeClass();
    if (msg == 'success') {
        $(destination).addClass('alert alert-success').text('Файл успешно загружен.');
    }
    if (msg == 'error') {
        $(destination).addClass('alert alert-danger').text('Произошла ошибка при загрузке файла.');
    }
    if (msg == 'error_file_check') {
        $(destination).addClass('alert alert-danger').text('Файл не выбран.');
    }
    if (msg == 'error_file_maxsize') {
        $(destination).addClass('alert alert-danger').text('Файл слишком большой.');
    }
    if (msg == 'error_type') {
        $(destination).addClass('alert alert-danger').text('Не верный тип файла (имя фаайла.jpg)');
    }
}
// (function($){
    // $(window).on("load",function(){

        // //Добавление фильтрации
        // $("#all-results-table").tablesorter({
        //     // hidden filter input/selects will resize the columns, so try to minimize the change
        //     // theme:'blue',
        //     widthFixed : true,


        //     headers: {
        //         // 0: { sorter: "select", filter: "parsed" },
        //         // 1: { sorter: "select", filter: "parsed" },
        //         // 2: { sorter: true, filter: false },
        //         // 3: { sorter: "input", filter: "parsed" },
        //         // 4: { sorter: "input", filter: "parsed" },
        //         // 5: { sorter: "input", filter: "parsed" },
        //         // 6: { sorter: "input", filter: "parsed" },
        //         // 7: { sorter: "input", filter: "parsed" },
        //         // 8: { sorter: "input", filter: "parsed" },
        //         // 9: { sorter: "input", filter: "parsed" },
        //         11: { sorter: false, filter: false }
        //     },
        //     widgets: [ "columns", "filter", "zebra" ],

        //     widgetOptions : {
        //         // extra css class applied to the table row containing the filters & the inputs within that row
        //         filter_cssFilter   : '',

        //         // If there are child rows in the table (rows with class name from "cssChildRow" option)
        //         // and this option is true and a match is found anywhere in the child row, then it will make that row
        //         // visible; default is false
        //         filter_childRows   : false,

        //         // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
        //         // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
        //         filter_hideFilters : false,

        //         // Set this option to false to make the searches case sensitive
        //         filter_ignoreCase  : true,

        //         // jQuery selector string of an element used to reset the filters
        //         // filter_reset : '.reset',

        //         // Use the $.tablesorter.storage utility to save the most recent filters
        //         // filter_saveFilters : true,

        //         // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
        //         // every character while typing and should make searching large tables faster.
        //         // filter_searchDelay : 300,

        //         // Set this option to true to use the filter to find text from the start of the column
        //         // So typing in "a" will find "albert" but not "frank", both have a's; default is false
        //         // filter_startsWith  : false,

        //         filter_searchFiltered : false,

        //         // Add select box to 4th column (zero-based index)
        //         // each option has an associated function that returns a boolean
        //         // function variables:
        //         // e = exact text from cell
        //         // n = normalized value returned by the column parser
        //         // f = search filter input value
        //         // i = column index
        //         filter_functions : {
        //         // 	// Add select menu to this column
        //         // 	// set the column value to true, and/or add "filter-select" class name to header
        //         // 	// '.first-name' : true,
        //         // 	// Exact match only
        //             // 1 : function(e, n, f, i, $r, c, data) {
        //             // return e === f;
        //             // },

        //         }
        //     },
        // });
        
        // //Добавление фильтарации
        // $("#all-subjects-table").tablesorter({
        //     widthFixed : true,
        //     widgets: [ "columns", "filter", "zebra" ],
        //     headers: {
        //         7: { sorter: false, filter: false }
        //     },
        //     widgetOptions : {
        //         filter_cssFilter   : '',
        //         filter_childRows   : false,
        //         filter_hideFilters : false,
        //         filter_ignoreCase  : true,
        //         filter_searchFiltered : false,
        //         filter_functions : {

        //         }
        //     },
        // });

        // //Добавление фильтарации
        // $("#questions-table-by-subject").tablesorter({
        //     widthFixed : true,
        //     widgets: [ "columns", "filter", "zebra" ],
        //     headers: {
        //         0: { sorter: true, filter: false },
        //         1: { sorter: false, filter: false },
        //         9: { sorter: false, filter: false }
        //     },
        //     widgetOptions : {
        //         filter_cssFilter   : '',
        //         filter_childRows   : false,
        //         filter_hideFilters : false,
        //         filter_ignoreCase  : true,
        //         filter_searchFiltered : false,
        //         filter_functions : {

        //         }
        //     },
        // });

    // });
// })(jQuery);

//Удалить результат пользователя
$(".delete-user-result").on("click", function(){
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
                    thisElement.parent().parent().parent().parent().remove();
                }
            },
        });
    }
});

//Действие над предметом - редактирование 
$(".subject-edit").on('click', function(){
    var sid = $(this).parent().data('sid');
    $.ajax({
        type: "POST",
        data: {status: 11, s: sid},
        url: "a_ajax_request.php",
        dataType : "json",   
        success: function(data){
            // console.log(data);
            // $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            document.getElementById('inputEditName').value = data['name'];
            document.getElementById('inputEditDescription').value = data['description'];
            document.getElementById('inputEditTime').value = data['time'];
            document.getElementById('inputEditAmount').value = data['amount'];
            document.getElementById('inputEditUprefix').value = data['uprefix'];
            document.getElementById('inputEditDateStart').value = data['date_start'];
            document.getElementById('inputEditDateEnd').value = data['date_end'];
            $('#edit-subject-submit').data('id', sid);
            // if(data['status'] == 1){
                // thisElement.parent().parent().remove();
            // }
        },
    });
});

//Действие над предметом - клонирование 
$(".subject-clone").on('click', function(){
    var sid = $(this).parent().data('sid');
    var table = $('#all-subjects-table tbody');
    var lastSubjectNumber = table.find("tr").last().find("th").text();
    $.ajax({
        type: "POST",
        data: {status: 14, s: sid},
        url: "a_ajax_request.php",
        dataType : "json",   
        success: function(data){
            var subject_data = data['result'];
            if(data['status'] == 1){
                $(".res-table-message").append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var subject_row = "";
                if(subject_data['display'] == 0){
                    subject_row +="<tr class = 'subject_unvis'>";
                }else{
                    subject_row +="<tr>";
                }
                subject_row +=
                    "<th scope='row'>"+(++lastSubjectNumber)+"</th>"+
                    "<td>"+subject_data['name']+"</td>"+
                    "<td>"+subject_data['time']+"</td>"+
                    "<td>"+subject_data['amount']+"</td>"+
                    "<td>"+subject_data['uprefix']+"</td>"+
                    "<td>"+subject_data['date_start']+"</td>"+
                    "<td>"+subject_data['date_end']+"</td>"+
                    "<td class='table-row-act'>"+
                        "<div class='dropdown'>"+
                            "<a class='subject-dropdown-menu' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                            "<i class='fa fa-cog'></i>"+
                            "</a>"+
                            "<div class='dropdown-menu' data-sid='"+subject_data['id']+"'>"+
                                "<a class='dropdown-item subject-edit' data-toggle='modal' data-target='#editSubjectModal' href='#'>Редактировать</a>"+
                                "<a class='dropdown-item subject-clone' href='#'>Склонировать</a>";
                                if(subject_data['display'] == 0){
                                    subject_row+="<a class='dropdown-item subject-delete' data-vis=1 href='#'>Показать</a>";
                                }else{
                                    subject_row+="<a class='dropdown-item subject-delete' data-vis=0 href='#'>Скрыть</a>";
                                }
                            subject_row+="</div>"+
                        "</div>"+
                    "</td>"+
                "</tr>";
                table.append(subject_row);
            }else{
                $(".res-table-message").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        },
    });
});

//Действие над предметом - скрыть/показать 
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
                tableRow.find('td:eq( 3 )').text(fData['uprefix']);
                tableRow.find('td:eq( 4 )').text(fData['date_start']);
                tableRow.find('td:eq( 5 )').text(fData['date_end']);
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
            let tbody = document.getElementById("questions-table-by-subject").childNodes[4];
            let inc = 0;
            data.forEach(function(item){
                let answers = item['answers'].split(",");
                // console.log(answers);
                tableRow.append('<tr>'
                    +'<th>'+(++countQuestion)+'</th>'
                    +'<td><img class="question-img" src="../../'+item['question_img']+'" alt=""></td>'
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
                for(let i=0; i<answers.length; i++){
                    // console.log(answers[i]);
                    tbody.childNodes[inc].childNodes[parseInt(answers[i])+2].classList.add("questions-select-true");
                }
                inc++;
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

//Действие над вопросом
$("#questions-table-by-subject").on('click', '.question-edit', function(){
    var qid = $(this).parent().data('qid');
    $.ajax({
        type: "POST",
        data: {status: 22, q: qid},
        url: "a_ajax_request.php",
        dataType : "json",   
        success: function(data){
            // console.log(data);
            var answers = data['answers'].split(",");
            // console.log(answers);
            for(let i=1; i<=6; i++){
                $('#inputUpdateOptionType'+i).prop('checked', false);						
            }
            for(let i=1; i<=answers.length; i++){
                $('#inputUpdateOptionType'+answers[i-1]).prop('checked', true);						
            }


            // $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            if(data['question_img'] !== null && data['question_img'] !== "" && data['question_img']){
                document.getElementById('question-edit-image-preview').style.backgroundImage = "url(../../"+data['question_img']+")";
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

// Создание вопроса
$('.form-create-question-image').on('submit', (function(e) {
    e.preventDefault();
    
    var selected_subject = $('#select-subject').val();
    
    if(selected_subject == 0){
        alert("Выберите олимпиаду");
    }else{
        // var self = this;
        var thisElement = $(this);
        thisElement.find('input[name=sid]').val(selected_subject);
        thisElement.find('input[name=type]').val('s');
        
        
        $.ajax({
            type: 'POST',
            url: 'a_ajax_request.php',
            data: {status: 26},
            dataType : "json",
            success: function(data){
                var selected_question = data;
                // alert(data);
                thisElement.find('input[name=qid]').val(selected_question);

                var selectedImage = document.getElementById('question-create-image-input').value;
                // console.log("this" + $(this)[0]);
                // console.log("file" + formImageData);
                // console.log("sel_quest: " + selected_question);
                // console.log("sel_qid: " + thisElement.find('input[name=qid]').val());
                if(selectedImage != ""){
                    var formImageData = document.getElementById("formCreateQuestionImage");
                    var image = new FormData(formImageData);
                    $.ajax({
                        type:'POST', // Тип запроса
                        url: 'upload_images.php', // Скрипт обработчика
                        data: image, // Данные которые мы передаем
                        cache: false, // В запросах POST отключено по умолчанию, но перестрахуемся
                        contentType: false, // Тип кодирования данных мы задали в форме, это отключим
                        processData: false, // Отключаем, так как передаем файл
                        success:function(data){
                            data = data.split('-');
                            if(data[0] == 'success'){
                                
                            }
                            // printMessage('#result', data[0]);
                        },
                        error:function(data){
                            // console.log('no');
                            // console.log(data);
                        }
                    });
                }
                var formData = $('.form-create-question').serializeArray();
                $.ajax({
                    type: 'POST',
                    url: 'a_ajax_request.php',
                    data: {status: 23, fd: formData, q: selected_question, s: selected_subject, si: selectedImage},
                    dataType : "json",
                    beforeSend: function() {
                        $('#createQuestionLoadSuccess').html('<img src="../../icon/load.gif">');
                    },
                    success: function(data){
                        $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#createQuestionLoadSuccess').html('<img src="../../icon/success.png">');
                        
                        if(data['status'] == 1){
                            //Сброс картинки после успешной записи
                            document.getElementById('question-create-image-preview').style.backgroundImage = "none";
                            document.getElementById('question-create-image-input').value = "";

                            //Сброс полей ввода 
                            document.getElementById('inputCreateQuestion').value = "";
                            for(let i=1; i<=6; i++){						
                                document.getElementById('inputCreateOption'+i).value = "";
                            }
                            for(let i=1; i<=6; i++){
                                $('#inputCreateOptionType'+i).prop('checked', false);						
                            }

                            $('#create-question-submit').data('id', "");
                            $('#question-create-image-preview').find('input[name=qid]').val("");
                            // $('#create-question-submit').('input[name=qid]').val("");
                            $('input[id="create-question-submit"]').removeClass('btn-primary');
                            $('input[id="create-question-submit"]').addClass('btn-secondary');
                            $('#create-question-submit').attr('disabled', true);
                            $('#create-question-submit').attr("id", "create-question-sabmit");	
                            function setIdSubmitButton() {
                                $('#create-question-sabmit').attr("id", "create-question-submit");
                                $('input[id="create-question-submit"]').removeClass('btn-secondary');
                                $('input[id="create-question-submit"]').addClass('btn-primary');
                                $('#create-question-submit').removeAttr('disabled');
                                $('#createQuestionLoadSuccess').html('<img src="../../icon/peace.png">');
                            }
                            setTimeout(setIdSubmitButton, 8000);
                        }
                        // console.log(data);
                    },
                    error: function(){
                        $('#createQuestionLoadSuccess').html('<img src="../../icon/danger.png">');
                        // console.log('error');
                    }
                });
            },
            error: function(){
                // console.log('error');
            }
        });

        
    }
}));

$("#questions-table-by-subject").on('click', '.question-delete', function(){
    var qid = $(this).parent().data('qid');
    var selected_subject = $('#select-subject').val();
    $.ajax({
        type: 'POST',
        url: 'a_ajax_request.php',
        data: {status: 25, s: selected_subject, q: qid},
        dataType: 'json',
        success: function(data){
            $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            // console.log("success");
            // console.log(data);
        },
        error: function(data){
            // console.log("error");
        }
    });
});

// Обновление вопроса
$('.form-edit-question-image').on('submit', (function(e) {
    e.preventDefault();
    
    var selected_subject = $('#select-subject').val();
    var selected_question = $('#edit-question-submit').data('id');

    if(selected_subject == 0){
        alert("Выберите олимпиаду");
    }else{
        var selectedImageEdit = document.getElementById('question-edit-image-input').value;
        // input.onchange = function(e) { 
        // console.log("selectImg: "+selectedImageEdit);
        // console.log("selectImg type: "+typeof selectedImageEdit);
        // };
        $(this).find('input[name=sid]').val(selected_subject);
        $(this).find('input[name=qid]').val(selected_question);
        $(this).find('input[name=type]').val('u');

            // if(!!selectedImageEdit || selectedImageEdit == " "){
            // 	console.log("save file");
            // }else{
            // 	console.log("no save file");
            // }
        if(!!selectedImageEdit || selectedImageEdit == " "){
            var image = new FormData(this);
            $.ajax({
                type:'POST', // Тип запроса
                url: 'upload_images.php', // Скрипт обработчика
                data: image, // Данные которые мы передаем
                cache: false, // В запросах POST отключено по умолчанию, но перестрахуемся
                contentType: false, // Тип кодирования данных мы задали в форме, это отключим
                processData: false, // Отключаем, так как передаем файл
                success:function(data){
                    data = data.split('-');
                    if(data[0] == 'success'){
                        // var formData = $('.form-edit-question').serializeArray();
                        // // console.log(formData);
                        // $.ajax({
                        // 	type: 'POST',
                        // 	url: 'a_ajax_request.php',
                        // 	data: {status: 24, fd: formData, q: selected_question, s: selected_subject},
                        // 	dataType : "json",
                        // 	success: function(data){
                        // 		console.log(data);
                        // 	},
                        // 	error: function(data){
                        // 		console.log('error');
                        // 	}
                        // });
                        // $('#image').val('');
                        // $('#preview').remove();
                        // $('#templates').prepend("<div class='col-md-4 img-template my-col'><img src='templates/"+data[1]+".jpg' alt='' class='img-thumbnail my-image-prev'><span class='close' data-id='"+data[1]+"'>&times;</span></div>");
                    }
                    // printMessage('#result', data[0]);
                },
                error:function(data){
                    // console.log('no');
                    // console.log(data);
                }
            });
        }


        var formData = $('.form-edit-question').serializeArray();
        $.ajax({
            type: 'POST',
            url: 'a_ajax_request.php',
            data: {status: 24, fd: formData, q: selected_question, s: selected_subject, si: selectedImageEdit},
            dataType : "json",
            beforeSend: function() {
                $('#editQuestionLoadSuccess').html('<img src="../../icon/load.gif">');
            },
            success: function(data){
                $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                $('#editQuestionLoadSuccess').html('<img src="../../icon/success.png">');
                // console.log(data);
                if(data == 1){
                    // $('#editQuestionModalLabel').parent().parent().css('border', '1px solid rgb(77, 247, 46)');
                }
            },
            error: function(data){
                $('#editQuestionLoadSuccess').html('<img src="../../icon/danger.png">');
                // console.log('error');
            }
        });

    }
}));
$("#questions-table-by-subject").on('click', '.question-img', function(){
    if($(this).hasClass('question-img')){
        $(this).removeClass('question-img');
        $(this).addClass('question-img-big');
    }
});
$("#questions-table-by-subject").on('click', '.question-img-big', function(){
    if($(this).hasClass('question-img-big')){
        $(this).removeClass('question-img-big');
        $(this).addClass('question-img');
    }	
});


//Действие над результатами пользователей - апелляция 
$("#all-results-table").on('click', '.show-apelation', function(){
    var thisElem = $(this);
    var sid = $(this).parent().data('sid');
    var uid = $(this).parent().data('uid');
    $.ajax({
        type: "POST",
        data: {status: 30, s: sid, u: uid},
        url: "a_ajax_request.php",
        dataType : "json",   
        success: function(data){
            // var data = JSON.parse(data);
            // $(".res-table-message").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+data['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            // console.log(data['user_questions']);
            // console.log(data['user_selected_options']);
            // $.each(data['user_questions'], function(key, value){
            // 	// console.log(key + ": ");
            // 	console.log(value['id']+": ");
            // 	console.log(value['question']+ " " +value['option_1']+ " " +value['option_2']+ " " +value['option_3']+ " " +value['option_4']+ " " +value['option_5']+ " " +value['option_6']);
            var questions_string = '';
            var amount_user_questions = Object.keys(data['user_questions']).length;
            console.log(amount_user_questions);
            if(amount_user_questions > 0){
                $.each(data['user_questions'], function (index, array_quest){
                    // console.log(data['user_selected_options'][array_quest['id']]);
                    // if(index === 0){
                    // 	questions_string += '<div class="test-question tq-visible" data-id="'+array_quest['id']+'" data-num="'+(index+1)+'">';
                    // }else{
                        questions_string += '<div class="apelation-question" data-id="'+array_quest['id']+'" data-num="'+(index+1)+'">';
                    // }
                    var answer_value = (array_quest['answers']).split(',');
    
                    if(array_quest['question_img'] != null && !!array_quest['question_img']){
                        questions_string+='<img class="apelation-img" src="../'+array_quest['question_img']+'">'+
                        '<p class="apelation-question-middle">'+array_quest['question']+'</p>';
                    }else{
                        questions_string+='<p class="apelation-question-first">'+array_quest['question']+'</p>';
                    }
                    // if(array_quest['answers'] === 'more'){
                    // 	for(var i = 0; i <= 5; i++){
                    // 		if(array_quest['option_'+(i+1)] !== null && array_quest['option_'+(i+1)] !== ""){
                    // 			questions_string+='<div class="inputGroup my-checkbox-style">'+array_quest['option_'+(i+1)]+'</div>';
                    // 		}
                    // 	}
                    // }else{
                    amount_answer_value = answer_value.length;
                    // console.log("answer value: " + amount_answer_value);
                    if(amount_answer_value > 1){
                        // console.log("amount_answer_value: "+amount_answer_value);
                        for(var i = 0; i <= 5; i++){
                            // console.log(answer_value[i] +" - "+ array_quest['option_'+(i+1)]);
                            if(array_quest['option_'+(i+1)] !== null && array_quest['option_'+(i+1)] !== ""){
                                if(in_array((i+1), answer_value)){
                                    // console.log(array_quest['option_'+(i+1)] +" - "+ data['user_selected_options'][array_quest['id']]);
                                    if(in_array(array_quest['option_'+(i+1)], data['user_selected_options'][array_quest['id']])){
                                        questions_string+='<div class="apelation-option apelation-true-option tuserselect">'+array_quest['option_'+(i+1)]+'</label></div>';
                                    }else{
                                        questions_string+='<div class="apelation-option apelation-true-option">'+array_quest['option_'+(i+1)]+'</label></div>';
                                    }
                                }else{
                                    if(in_array(array_quest['option_'+(i+1)], data['user_selected_options'][array_quest['id']])){
                                        questions_string+='<div class="apelation-option fuserselect">'+array_quest['option_'+(i+1)]+'</label></div>';
                                    }else{
                                        questions_string+='<div class="apelation-option">'+array_quest['option_'+(i+1)]+'</label></div>';
                                    }
                                }
                            }
                        }
                    }else if(amount_answer_value == 1){
                        // console.log("amount_answer_value: "+amount_answer_value);
                        for(var i = 0; i <= 5; i++){
                            // console.log(answer_value +" - "+ array_quest['option_'+(i+1)]);
                            if(array_quest['option_'+(i+1)] !== null && array_quest['option_'+(i+1)] !== ""){
                                if(answer_value[0] == (i+1)){
                                    if(array_quest['option_'+(answer_value[0])] == data['user_selected_options'][array_quest['id']]){
                                        questions_string+='<div class="apelation-option apelation-true-option tuserselect">'+array_quest['option_'+(answer_value[0])]+'</label></div>';
                                    }else{
                                        questions_string+='<div class="apelation-option apelation-true-option">'+array_quest['option_'+(answer_value[0])]+'</label></div>';
                                    }
                                }else{
                                    if(array_quest['option_'+(i+1)] == data['user_selected_options'][array_quest['id']]){
                                        questions_string+='<div class="apelation-option fuserselect">'+array_quest['option_'+(i+1)]+'</label></div>';
                                    }else{
                                        questions_string+='<div class="apelation-option">'+array_quest['option_'+(i+1)]+'</label></div>';
                                    }
                                }
                            }
                        }
                    }
                    // }
                    questions_string += '</div>';
                });
                $(".apelation-result").html(questions_string);
            }else{
                $(".apelation-result").html('<div class="no_result">НЕТ ОТВЕТОВ!</div>');
            }
            // $.each(data['user_selected_options'], function(key, value){
            // 	console.log(key +" "+ value);
            // });

            // if(data['status'] == 1){
                // thisElement.parent().parent().remove();
            // }
        },
    });
});

function in_array(needle, haystack, strict) {
    var found = false, key, strict = !!strict;
    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }
    return found;
}
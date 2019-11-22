//**для dialog окон**//
// var height = function(){
// 	if(getPageSize()[2] <= '1380'){
// 		return getPageSize()[3];
// 	}
// 	else{
// 		return getPageSize()[3]-107;
// 	}
// };
// var position = function(){
// 	if(getPageSize()[2] <= '1380'){
// 		return "left top";
// 	}
// 	else{
// 		return "right bottom";
// 	}
// };
// $(function(){
// 	$( "#annotation" ).dialog({
// 		position: { 
// 			my: position(), 
// 			at: position(), 
// 			of: "body" 
// 		},
// 		autoOpen: false,
// 		show: {
// 	effect: "blind",
// 	duration: 400
//   },
//   hide: {
// 	effect: "explode",
// 	duration: 400
//   },
// 		width: getPageSize()[2],
// 		height: height(),
// 		buttons: [
// 			{
// 				text: "Cancel",
// 				click: function() {
// 					$( this ).dialog( "close" );
// 				}
// 			}
// 		]
// 	});
// 	$( "a.color1" ).click(function(event) {
// 		$( "#annotation" ).dialog('open');
// 		event.preventDefault();
// 	});
// });
//==================//


//**для чек боксов**//
// $( function() {
//   $( "input" ).checkboxradio();
// });
//==================//

//****для блока со временем***//
// $('.test-time-block').draggable();
//============================//



//***для кнопки наверх***//
$(document).ready(function(){
	// hide #back-top first
	$("#back-top").hide();
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});
//=================//

var questions_data;


//***для кнопки start***//
(function(){
	function getUrlVars() {
	    var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	        vars[key] = value;
	    });
	    return vars;
	}
	var timerId = '';
	var startFlag = 0;
	var submitFlag = 0;
	var timeFlag = 1;
	var id = getUrlVars()["id"];

	$('.start-timer').on('click', function(){
		//**для чек боксов**//
		// $( function() {
		  // $( "input" ).checkboxradio();
		// });
		//==================//
		// $('.test-time-start').removeClass('start-timer');
		$('.test-time-start').css({'display': 'none'});
		if(timeFlag == 1){
			var start = 'start';
			$.ajax({
				type: "POST",
				data: {start: start, id: id},
				url: "ajax_request.php",
				dataType : "json",   
				success: function(data){
					// questions_data = data;
					// console.log(data);

					$.each(data, function (index, array_quest){
						if(index === 0){
							$('.all-questions ul').append('<li class="q-active-i" data-id="'+array_quest['id']+'">'+(index+1)+'</li>');
						}else{
							$('.all-questions ul').append('<li data-id="'+array_quest['id']+'">'+(index+1)+'</li>');
						}
					});

					var questions_string = '';
					$.each(data, function (index, array_quest){
						if(index === 0){
							questions_string += '<div class="test-question tq-visible" data-id="'+array_quest['id']+'" data-num="'+(index+1)+'">';
						}else{
							questions_string += '<div class="test-question" data-id="'+array_quest['id']+'" data-num="'+(index+1)+'">';
						}
						// var answer_value = array_quest['answers'].split(',').length;

			  		if(array_quest['question_img'] != null){
			  			questions_string+='<img src="'+array_quest['question_img']+'">'+
			  			'<p class="question-middle">'+array_quest['question']+'</p>';
			  		}else{
			  			questions_string+='<p class="question-first">'+array_quest['question']+'</p>';
			  		}
			  		if(array_quest['answers'] === 'more'){
			  			for(var i = 0; i <= 5; i++){
			  				if(array_quest['option_'+(i+1)] !== null && array_quest['option_'+(i+1)] !== ""){
				  				questions_string+='<div class="inputGroup my-checkbox-style"><input type="checkbox" name="checkbox-'+(array_quest['id'])+':'+i+'" id="checkbox-'+(array_quest['id']+i)+'" value="'+array_quest['option_'+(i+1)]+'"><label for="checkbox-'+(array_quest['id']+i)+'">'+array_quest['option_'+(i+1)]+'</label></div>';
				  			}
			  			}
			  		}else{
			  			for(var i = 0; i <= 5; i++){
			  				if(array_quest['option_'+(i+1)] !== null && array_quest['option_'+(i+1)] !== ""){
				  				questions_string+='<div class="inputGroup my-radio-style"><input type="radio" name="radio-'+array_quest['id']+'" id="radio-'+(array_quest['id']+i)+'" value="'+array_quest['option_'+(i+1)]+'"><label for="radio-'+(array_quest['id']+i)+'">'+array_quest['option_'+(i+1)]+'</label></div>';
				  			}
			  			}
			  		}
						questions_string += '</div>';
					});
					$('.form-for-test').html(questions_string);
					$('.section-test').append('<button class="prev btn btn-primary btn-lg">Назад</button>');
					$('.section-test').append('<input class="submit-test btn btn-success btn-lg" type="button" value="Завершить тест">');
					$('.section-test').append('<button class="next btn btn-primary btn-lg">Далее</button>');
					// $('.section-test').append('<br><br>');
				}
			});
			timeFlag = 0;
		}

		var hourElem = $('.test-hour');
		var minElem = $('.test-minutes');
		var secElem = $('.test-seconds');
		var hourVal = parseInt(hourElem.html());
		var minVal = parseInt(minElem.html());
		var secVal = parseInt(secElem.html());
		// var timeDelimeter = $('.test-delimiter').html();
		var submit = 'submit';
		// var timeLeft = minVal+":"+secVal;

		$( ".section-test" ).on('click', '.submit-test', function() {
			if(submitFlag !== 1){
				// $('.test-time-start').removeClass('start-timer');
				var formData = $('.form-for-test').serializeArray();
				// $( ".form-for-test" ).submit();

				// var url = window.location.href;
				// console.log(url);
				// console.log(id);
				var timeLeft = minElem.html()+":"+secElem.html();
				$.ajax({
					type: "POST",
					data: {submit: submit, id: id, formData: formData, timeLeft: timeLeft},
					url: "ajax_request.php",
					success: function(data){
						var response = data.split("-");
						$('.section-test').remove();
						$('section').append('<div class="section-result text-center mt-5 mb-5"><h1>'+response[0]+' балла(ов)</h1><p>тест пройден за '+response[1]+', верно '+response[2]+'</p></div>');
//						$('.test-time p').html(data);
					}
				});
				clearTimeout(timerId);
				submitFlag = 1;
			}
			// $(".submit-test").removeClass('submit-test');
		});

		// console.log(+secVal);
		function calcTime() {
			if(+secVal < 1){
				if(+minVal < 1){
					if(+hourVal < 1){
						hourVal = 0;
						hourElem.html(hourVal);
						minVal = 0;
						minElem.html(minVal);
						secVal = 0;
						secElem.html(secVal);
						var formData = $('.form-for-test').serializeArray();
						var timeLeft = hourElem.html()+":"+minElem.html()+":"+secElem.html();
						$('.test-time-start').addClass('start-timer');
						// $( ".form-for-test" ).submit();
						$.ajax({
							type: "POST",
							data: {submit: submit, id: id, formData: formData, timeLeft: timeLeft},
							url: "ajax_request.php",
							success: function(data){
								var response = data.split("-");
								$('.section-test').remove();
								$('section').append('<div class="section-result text-center mt-5 mb-5"><h1>'+response[0]+' балла(ов)</h1><p>тест пройден за <b>'+response[1]+'</b>, верно <b>'+response[2]+'</b></p></div>');
	//							$('.test-time p').html(data);
							}
						});
						submitFlag = 1;
					}else{
						hourElem.html(hourVal);
						hourVal -= 1;
						minVal = 0;
						minElem.html(minVal);
						secVal = 0;
						secElem.html(secVal);
						timerId = setTimeout(calcTime, 1000);
						minVal = 59;
						secVal = 59;	
					}
				}
				else{
					hourElem.html(hourVal);
					minElem.html(minVal);
					minVal -= 1;
					secVal = 0;
					secElem.html(secVal);
					// if(timerId === ''){
						timerId = setTimeout(calcTime, 1000);
					// }
					secVal = 59;
				}
			}
			else{
				hourElem.html(hourVal);
				minElem.html(minVal);
				secElem.html(secVal);
				secVal -= 1;
				// if(timerId === ''){
					timerId = setTimeout(calcTime, 1000);
				// }
			}
			
		}
		if(submitFlag !== 1 && startFlag !== 1){
			calcTime();
			startFlag = 1;
		}
	});
})();
//=================//

$(".section-test").on('click', '.all-questions ul li', function(){
	var dataId = $(this).data()['id'];
	
	$('.all-questions ul li.q-active-i').removeClass('q-active-i');
	$(this).addClass('q-active-i');

	$('.tq-visible').removeClass('tq-visible');
	$('.test-question[data-id='+dataId+']').addClass('tq-visible');

});

$(".section-test").on('click', '.next', function(){
	var dataNum = $('.tq-visible').data()['num'];
	var dataIdPlus = parseInt(dataNum) + 1;
	//alert(dataNum);
	//alert(dataIdPlus);
	if($('div').is('.test-question[data-num="'+dataIdPlus+'"]')){
		$('.tq-visible').removeClass('tq-visible');
		$('.test-question[data-num='+dataIdPlus+']').addClass('tq-visible');

		var checkButt = $('.test-question[data-num='+dataIdPlus+']').data()['id'];
		$('.all-questions ul li.q-active-i').removeClass('q-active-i');
		$('.all-questions ul li[data-id="'+checkButt+'"]').addClass('q-active-i');
	}
	//alert(dataIdPlus);
	//if(){

	//}
	//$('.test-question[data-id='+dataId[0]+'-'+dataId[1]+']').addClass('tq-visible');
});
$(".section-test").on('click', '.prev', function(){
	var dataNum = $('.tq-visible').data()['num'];
	var dataIdMinus = parseInt(dataNum) - 1;
	//alert(dataNum);
	//alert(dataIdMinus);
	if($('div').is('.test-question[data-num="'+dataIdMinus+'"]')){
		$('.tq-visible').removeClass('tq-visible');
		$('.test-question[data-num='+dataIdMinus+']').addClass('tq-visible');

		var checkButt = $('.test-question[data-num='+dataIdMinus+']').data()['id'];
		$('.all-questions ul li.q-active-i').removeClass('q-active-i');
		$('.all-questions ul li[data-id="'+checkButt+'"]').addClass('q-active-i');
	}
	//alert(dataIdMinus);
});

$(".section-test").on('click', '.inputGroup input', function(){
	var questionDataId = $(this).parent().parent().data()['id'];
	if($(this).is(":checked")){
		if(!$('.all-questions ul li[data-id="'+questionDataId+'"]').hasClass('q-answered-i')){
			$('.all-questions ul li[data-id="'+questionDataId+'"]').addClass('q-answered-i');
		}
	}else{
		var check0 = $('.inputGroup input[id="checkbox-'+questionDataId+'0"]').is(":checked");
		var check1 = $('.inputGroup input[id="checkbox-'+questionDataId+'1"]').is(":checked");
		var check2 = $('.inputGroup input[id="checkbox-'+questionDataId+'2"]').is(":checked");
		var check3 = $('.inputGroup input[id="checkbox-'+questionDataId+'3"]').is(":checked");
		var check4 = $('.inputGroup input[id="checkbox-'+questionDataId+'4"]').is(":checked");
		var check5 = $('.inputGroup input[id="checkbox-'+questionDataId+'5"]').is(":checked");

		if(!check0 && !check1 && !check2 && !check3 && !check4 && !check5){
			if($('.all-questions ul li[data-id="'+questionDataId+'"]').hasClass('q-answered-i')){
				$('.all-questions ul li[data-id="'+questionDataId+'"]').removeClass('q-answered-i');
			}
		}
	}
});

(function(){
    var optionValue = $("#selectTrainingDiraction option:selected").val();
    if(optionValue == 0){
    	$("#inputTrainingDirection").css({display:"none"});
        $("#inputlLevelOfTraining").css({display:"none"});
    }
    if(optionValue == 1){
        $("#inputTrainingDirection").css({display:"none"});
        $("#inputlLevelOfTraining").css({display:"none"});
        $("#inputTrainingDirection").attr("value", "школа");
        $("#inputlLevelOfTraining").val("0");
    }
    if(optionValue == 2){
        $("#inputTrainingDirection").css({display:"block"});
        $("#inputlLevelOfTraining").css({display:"block"});
    }
    if(optionValue == 3){
    	$("#inputTrainingDirection").css({display:"block"});
    	$("#inputlLevelOfTraining").css({display:"none"});
    	$("#inputlLevelOfTraining").val("0");	
    }
    $("#selectTrainingDiraction").on('change', function(){
        var optionValue = $("#selectTrainingDiraction option:selected").val();
        if(optionValue == 0){
        	$("#inputTrainingDirection").css({display:"none"});
        	$("#inputlLevelOfTraining").css({display:"none"});
        	$("#inputTrainingDirection").attr("value", "");
            $("#inputlLevelOfTraining").val("0");
        }
        if(optionValue == 1){
            $("#inputTrainingDirection").css({display:"none"});
            $("#inputlLevelOfTraining").css({display:"none"});
            $("#inputTrainingDirection").attr("value", "школа");
            $("#inputlLevelOfTraining").val("0");
        }
        if(optionValue == 2){
            $("#inputTrainingDirection").css({display:"block"});
            $("#inputlLevelOfTraining").css({display:"block"});
            $("#inputTrainingDirection").attr("value", "");
            $("#inputlLevelOfTraining").val("0");
        }
        if(optionValue == 3){
        	$("#inputTrainingDirection").css({display:"block"});
            $("#inputlLevelOfTraining").css({display:"none"});
            $("#inputTrainingDirection").attr("value", "");
            $("#inputlLevelOfTraining").val("0");
        }
    });
})();
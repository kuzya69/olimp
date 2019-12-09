//при нажатии на кнопку меню показать блок меню
// $(function(){
//     $('.button-menu').click(function(){
//         $('.navigation ul, .button-menu').toggleClass('active');
//     });
// });

//при изменении размера окна браузера убрать класс с элементов меню
// $(window).resize(function () {
// 	if($(window).width() > '1024'){
// 		$('.navigation ul, .button-menu').removeClass('active');
// 	}
// });

// возвращает размеры экрана
function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else if (document.documentElement && document.documentElement.scrollHeight > document.documentElement.offsetHeight){ // Explorer 6 strict mode
		xScroll = document.documentElement.scrollWidth;
		yScroll = document.documentElement.scrollHeight;
	} else { // Explorer Mac...would also work in Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	var windowWidth, windowHeight;
	if (self.innerHeight) { // all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else {
		pageHeight = yScroll;
	}
	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}
	return [pageWidth,pageHeight,windowWidth,windowHeight];
}


	// $(document).ready(function(){
	// 	$('li.subject_name').on('click', function(){	
	// 		$.ajax({
	// 			type: "POST",
	// 			data: {id:$(this).attr('id')},
	// 			// dataType: "html",
	// 			url: "page.php",
	// 			success: function(data){
	// 				// data = JSON.parse(data);
	// 		        $("div.page-data").html(data);
	// 				// $("div.section").append(data);
	// 			}
	// 		});
	// 	});
	// });
	// $(document).ready(function(){
	// 	$('li.lab_subject_name').on('click', function(){	
	// 		$.ajax({
	// 			type: "POST",
	// 			data: {id:$(this).attr('id')},
	// 			// dataType: "html",
	// 			url: "labs.php",
	// 			success: function(data){
	// 				// data = JSON.parse(data);
	// 		        $("div.page-data").html(data);
	// 				// $("div.section").append(data);
	// 			}
	// 		});
	// 	});
	// });

	// $(document).ready(function(){
	// 	var start = 0;
	// 	$('div.video-more').on('click', function(){	
	// 		$.ajax({
	// 			type: "POST",
	// 			data: {start: start},
	// 			// dataType: "html",
	// 			url: "video.php",
	// 			success: function(data){
	// 				console.log(data);
	// 				data = JSON.parse(data);
	// 				if(data.length > 0){
	// 					console.log('ok');
	// 					$.each(data, function(index, value){
	// 						console.log('ok');
	// 						console.log(index +' '+ value['name']);
	// 						$('.page-video-data').append('<iframe class="video-frame" src="'+value['link']+'" frameborder="0" allowfullscreen>'+value['name']+'</iframe>');
	// 					});
	// 				}
	// 				start +=4;
	// 			}
	// 		});
	// 	});
	// });
	// $(document).ready(function(){
	// 	var start = 0;
	// 	$('div.prez-more').on('click', function(){	
	// 		$.ajax({
	// 			type: "POST",
	// 			data: {start: start},
	// 			// dataType: "html",
	// 			url: "prez.php",
	// 			success: function(data){
	// 				console.log(data);
	// 				data = JSON.parse(data);
	// 				if(data.length > 0){
	// 					console.log('ok');
	// 					$.each(data, function(index, value){
	// 						console.log('ok');
	// 						console.log(index +' '+ value['name']);
	// 						$('.page-prez-data').append('<iframe class="video-frame" src="'+value['link']+'" frameborder="0" allowfullscreen>'+value['name']+'</iframe>');
	// 					});
	// 				}
	// 				start +=4;
	// 			}
	// 		});
	// 	});
	// });
	
	// $(document).ready(function(){
	// 	var start = 'start';
	// 	$('.start-timer').on('click', function(){	
	// 		$.ajax({
	// 			type: "POST",
	// 			data: {start: start},
	// 			// dataType: "html",
	// 			url: "tests.php",
	// 			success: function(data){
	// 				$('.form-for-test').html(data);
	// 				console.log(data);
	// 				// data = JSON.parse(data);
	// 				// if(data.length > 0){
	// 				// 	console.log('ok');
	// 				// 	$.each(data, function(index, value){
	// 				// 		console.log('ok');
	// 				// 		console.log(index +' '+ value['name']);
	// 				// 		$('.page-prez-data').append('<iframe class="video-frame" src="'+value['link']+'" frameborder="0" allowfullscreen>'+value['name']+'</iframe>');
	// 				// 	});
	// 				// }
	// 			}
	// 		});
	// 	});
	// });
	// $(document).ready(function(){
	// 	$( ".submit-test" ).click(function() {
	// 		$( ".form-for-test" ).submit();
	// 	});
	// });


	// $(document).ready(function(){
	// 	$('.lab_subject_name').on('click', function(){
	// 		$(this).toggleClass('.active-subject-name');
	// 	});
	// });

	// для выбора элементов списка на страницах page и labs
	$('.lab_subject_name').click(function() {
		$('.lab_subject_name').each(function(index, data){
			$(this).removeClass('active active-subject-name');
		});
   		$(this).toggleClass("active active-subject-name", true);
 	});
 	$('.subject_name').click(function() {
		$('.subject_name').each(function(index, data){
			$(this).removeClass('active active-subject-name');
		});
   		$(this).toggleClass("active active-subject-name", true);
 	});
	
 	// $(document).ready(function(){
 	// 	$.('.j-tools.bot-actions').css("display","none");
 	// 	$.('button.view-on-ss.btnViewOnSS').css("display","none");
 	// });

	// $(document).ready(function(){
	// 	var d = new Date();
	// 	var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
	// 	alert($.now() + time);
	// });
// console.log(getPageSize()[2], getPageSize()[3]);

// $(function(){
//     $(".div-dr").dialog();
// });
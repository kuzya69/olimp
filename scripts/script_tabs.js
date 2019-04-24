// $(document).load(function(){


// var height = function(){
// 	if(getPageSize()[2] <= '1380'){
// 		return getPageSize()[3];
// 	}
// 	else{
// 		return getPageSize()[3]-64;
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
//     effect: "blind",
//     duration: 400
//   },
//   hide: {
//     effect: "explode",
//     duration: 400
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

// $(function(){
// 	$( "#instraction-for-user" ).dialog({
// 		position: { 
// 			my: position(), 
// 			at: position(), 
// 			of: "body" 
// 		},
// 		autoOpen: false,
// 		show: {
//     effect: "blind",
//     duration: 400
//   },
//   hide: {
//     effect: "explode",
//     duration: 400
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
// 	$( "a.color2" ).click(function(event) {
// 		$( "#instraction-for-user" ).dialog('open');
// 		event.preventDefault();
// 	});
// });

// $(function(){
// 	$( "#reader" ).dialog({
// 		position: { 
// 			my: position(), 
// 			at: position(), 
// 			of: "body" 
// 		},
// 		autoOpen: false,
// 		show: {
//     effect: "blind",
//     duration: 400
//   },
//   hide: {
//     effect: "explode",
//     duration: 400
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
// 	$( "a.color6" ).click(function(event) {
// 		$( "#reader" ).dialog('open');
// 		event.preventDefault();
// 	});
// });

// $(function(){
// 	$( "#literature" ).dialog({
// 		position: { 
// 			my: position(), 
// 			at: position(), 
// 			of: "body" 
// 		},
// 		autoOpen: false,
// 		show: {
//     effect: "blind",
//     duration: 400
//   },
//   hide: {
//     effect: "explode",
//     duration: 400
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
// 	$( "a.color7" ).click(function(event) {
// 		$( "#literature" ).dialog('open');
// 		event.preventDefault();
// 	});
// });

// });
// 
// $(window).load(function() {
  $('span.test-tabs-btn.act').addClass("active");
  $('span.test-tabs-btn.pas').addClass("active");
  $('span.test-tabs-btn.npas').addClass("active");
  $('div.tile.act.pas').addClass('tile-visible');
  $('div.tile.act.npas').addClass('tile-visible');

  $('span.test-tabs-btn').click(function() {

  	var elClass = $(this).attr('class').split(' ');
    //Если нажата кнопка "активные"
    if(elClass[1] === 'act'){
      //Если статус активный был у "архивных" => удаляет статус 
      if($('span.test-tabs-btn.arc').hasClass("active") || $('span.test-tabs-btn.fut').hasClass("active")){
        $('span.test-tabs-btn.arc').removeClass("active");
        $('span.test-tabs-btn.fut').removeClass("active");

        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
      }
      //Если статус активный был у "активных" => удаляет статус 
      if(elClass[2] !== null && elClass[2] === 'active'){
        $(this).removeClass("active");
        $('span.test-tabs-btn.pas').removeClass("active");
        $('span.test-tabs-btn.npas').removeClass("active");

        //Включает активные прошедшие и не прошедшие
        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
        
      //Если статус активный не был у "активных" => добавляет статус 
      }else{
        $(this).addClass("active");
        $('span.test-tabs-btn.pas').addClass("active");
        $('span.test-tabs-btn.npas').addClass("active");

        //Выключает активные прошедшие и не прошедшие
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.act.pas').addClass('tile-visible');
        $('div.tile.act.npas').addClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
      }
    }
    //Если нажата кнопка "архивные"
    if(elClass[1] === 'arc'){
      //Если статус активный был у "активных" => удаляет статус 
      if($('span.test-tabs-btn.act').hasClass("active") || $('span.test-tabs-btn.fut').hasClass("active")){
        $('span.test-tabs-btn.act').removeClass("active");
        $('span.test-tabs-btn.fut').removeClass("active");

        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
      }
      //Если статус активный был у "архивных" => удаляет статус
      if(elClass[2] !== null && elClass[2] === 'active'){
        $(this).removeClass("active");
        $('span.test-tabs-btn.pas').removeClass("active");
        $('span.test-tabs-btn.npas').removeClass("active");

        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
        //Включает архивные прошедшие и не прошедшие
        
      //Если статус активный не был у "архивных" => добавляет статус
      }else{
        $(this).addClass("active");
        $('span.test-tabs-btn.pas').addClass("active");
        $('span.test-tabs-btn.npas').addClass("active");

        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').addClass('tile-visible');
        $('div.tile.arc.npas').addClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
        //Выключает архивные прошедшие и не прошедшие
        
      }
    }
    //Если нажата кнопка "будущие"
    if(elClass[1] === 'fut'){
      //Если статус активный был у "активных" или "архивных" => удаляет статус 
      if($('span.test-tabs-btn.act').hasClass("active") || $('span.test-tabs-btn.arc').hasClass("active")){
        $('span.test-tabs-btn.act').removeClass("active");
        $('span.test-tabs-btn.arc').removeClass("active");
      }
      //Если статус активный был у "будущих" => удаляет статус
      if(elClass[2] !== null && elClass[2] === 'active'){
        $(this).removeClass("active");
        $('span.test-tabs-btn.pas').removeClass("active");
        $('span.test-tabs-btn.npas').removeClass("active");

        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.fut.npas').removeClass('tile-visible');
      }else{
        $(this).addClass("active");
        $('span.test-tabs-btn.pas').removeClass("active");
        $('span.test-tabs-btn.npas').addClass("active");

        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.fut.npas').addClass('tile-visible');
      }
    }

    var elCalssAct = $('span.test-tabs-btn.act').attr('class').split(' ');
    //Если статус активный есть у "активных" 
    if(elCalssAct[2] === 'active'){
      //Если нажала кнопка "прошедшие"
      if(elClass[1] === 'pas'){
        $('div.tile.act.pas').removeClass('tile-visible');
        $('div.tile.act.npas').addClass('tile-visible');
        //Если статус активный был у "прошедших"
        if(elClass[2] !== null && elClass[2] === 'active'){
          var elClassNpas = $('span.test-tabs-btn.npas').attr('class').split(' ');
          $(this).removeClass("active");

          //Включает активные не прошедшие
          $('div.tile.act.npas').addClass('tile-visible');
          //Если у "не прошедших" нет статуса активный
          if(elClassNpas[2] !== 'active'){
            $('span.test-tabs-btn.act').removeClass("active");
            $('span.test-tabs-btn.arc').removeClass("active");

            $('div.tile.act.npas').removeClass('tile-visible');
          }
        //Если статус активный не был у "прошедших"
        }else{
          $(this).addClass("active");
          //Включает активные прошедшие и не прошедшие
          $('div.tile.act.pas').addClass('tile-visible');
          $('div.tile.act.npas').addClass('tile-visible');
        }
      }
      //Если нажала кнопка "не прошедшие"
      if(elClass[1] === 'npas'){
        $('div.tile.act.npas').removeClass('tile-visible');
        $('div.tile.act.pas').addClass('tile-visible');
        //Если статус активный был у "не прошедших"
        if(elClass[2] !== null && elClass[2] === 'active'){
          var elClassPas = $('span.test-tabs-btn.pas').attr('class').split(' ');
          $(this).removeClass("active");

          //Включает активные прошедшие
          $('div.tile.act.pas').addClass('tile-visible');
          //Если у "не прошедших" нет статуса активный
          if(elClassPas[2] !== 'active'){
            $('span.test-tabs-btn.act').removeClass("active");
            $('span.test-tabs-btn.arc').removeClass("active");

            $('div.tile.act.pas').removeClass('tile-visible');
          }
        //Если статус активный не был у "не прошедших"
        }else{
          $(this).addClass("active");
          //Включает активные прошедшие и не прошедшие
          $('div.tile.act.pas').addClass('tile-visible');
          $('div.tile.act.npas').addClass('tile-visible');
        }
      }
    }
    
    var elCalssArc = $('span.test-tabs-btn.arc').attr('class').split(' ');
    //Если статус активный есть у "архивных" 
    if(elCalssArc[2] === 'active'){
      //Если нажала кнопка "прошедшие"
      if(elClass[1] === 'pas'){
        $('div.tile.arc.pas').removeClass('tile-visible');
        $('div.tile.arc.npas').addClass('tile-visible');
        //Если статус активный был у "прошедших"
        if(elClass[2] !== null && elClass[2] === 'active'){
          var elClassNpas = $('span.test-tabs-btn.npas').attr('class').split(' ');
          $(this).removeClass("active");

          //Включает активные не прошедшие
          $('div.tile.arc.npas').addClass('tile-visible');
          //Если у "не прошедших" нет статуса активный
          if(elClassNpas[2] !== 'active'){
            $('span.test-tabs-btn.act').removeClass("active");
            $('span.test-tabs-btn.arc').removeClass("active");

            $('div.tile.arc.npas').removeClass('tile-visible');
          }
        //Если статус активный не был у "прошедших"
        }else{
          $(this).addClass("active");
          //Включает активные прошедшие и не прошедшие
          $('div.tile.arc.pas').addClass('tile-visible');
          $('div.tile.arc.npas').addClass('tile-visible');
        }
      }
      //Если нажала кнопка "не прошедшие"
      if(elClass[1] === 'npas'){
        $('div.tile.arc.npas').removeClass('tile-visible');
        $('div.tile.arc.pas').addClass('tile-visible');
        //Если статус активный был у "не прошедших"
        if(elClass[2] !== null && elClass[2] === 'active'){
          var elClassPas = $('span.test-tabs-btn.pas').attr('class').split(' ');
          $(this).removeClass("active");

          //Включает активные прошедшие
          $('div.tile.arc.pas').addClass('tile-visible');
          //Если у "не прошедших" нет статуса активный
          if(elClassPas[2] !== 'active'){
            $('span.test-tabs-btn.act').removeClass("active");
            $('span.test-tabs-btn.arc').removeClass("active");

            $('div.tile.arc.pas').removeClass('tile-visible');
          }
        //Если статус активный не был у "не прошедших"
        }else{
          $(this).addClass("active");
          //Включает активные прошедшие и не прошедшие
          $('div.tile.arc.pas').addClass('tile-visible');
          $('div.tile.arc.npas').addClass('tile-visible');
        }
      }
    }

    // if()
    // console.log(elClass);
  	// alert($(this).children('input').prop('checked'));
  	// if($(this).children('input').prop('checked') === true){
    	// alert('true');
    	// $('.tile'+elClass+'').addClass('tile-visible');
    	// $('.tile'+elClass+'').removeClass('tile-hidden');
  	// }
  	// if($(this).children('input').prop('checked') === false){
  		// alert('false');
  		// $('.tile'+elClass+'').removeClass('tile-visible');
  		// $('.tile'+elClass+'').addClass('tile-hidden');
  	// }
    // $('.tile').addClass('tile-hidden');
    // $('.tile').removeClass('tile-visible');
    // $('.test-tabs-btn').each(function(index, el) {
    	// alert(el);
    // });
    // switch($(this).attr('class').split(' ')[1]){
    // 	case 'act': 
    // 		console.log('act'); 
    // 		if($(this).hasClass('tile-visible') !== true){
  		// 		$('.tile.act').addClass('tile-visible'); 
  		// 	}
  		// 	if($(this).hasClass('tile-hidden') === true){
  		// 		$('.tile.act').removeClass('tile-hidden'); 
  		// 	}
  		// 	break;
    // 	case 'arc': 
    // 		console.log('arc'); 
    // 		if($(this).hasClass('tile-visible') !== true){
    // 			$('.tile.arc').addClass('tile-visible'); 
    // 		}
    // 		if($(this).hasClass('tile-hidden') === true){
  		// 		$('.tile.arc').removeClass('tile-hidden'); 
  		// 	}
    // 		break;
    // 	case 'pas': 
    // 		console.log('pas'); 
    // 		if($(this).hasClass('tile-visible') !== true){
    // 			$('.tile.pas').addClass('tile-visible'); 
    // 		}
    // 		if($(this).hasClass('tile-hidden') === true){
  		// 		$('.tile.pas').removeClass('tile-hidden'); 
  		// 	}
    // 		break;
    // 	case 'npas': 
    // 		console.log('npas'); 
    // 		if($(this).hasClass('tile-visible') !== true){
    // 			$('.tile.npas').addClass('tile-visible'); 
    // 		}
    // 		if($(this).hasClass('tile-hidden') === true){
  		// 		$('.tile.npas').removeClass('tile-hidden'); 
  		// 	}
    // 		break;
    // }
   //  if($(this).hasClass('act') === true){
   //  	// $('.tile').removeClass('tile-hidden, tile-visible');
   //  	// $('.tile').addClass('tile-hidden');
   //  	$('.tile.act, .tile').toggleClass('tile-visible');
   //  }
   //  if($(this).hasClass('arc') === true){
   //  	$('.tile').removeClass('tile-hidden, tile-visible');
   //  	$('.tile').addClass('tile-hidden');
   //  	$('.tile.arc').addClass('tile-visible');
  	// }
  	// if($(this).hasClass('pas') === true){
  	// 	$('.tile').removeClass('tile-hidden, tile-visible');
  	// 	$('.tile').addClass('tile-hidden');
   //  	$('.tile.pas').addClass('tile-visible');
  	// }
  	// if($(this).hasClass('npas') === true){
  	// 	$('.tile').removeClass('tile-hidden, tile-visible');
  	// 	$('.tile').addClass('tile-hidden');
   //  	$('.tile.npas').addClass('tile-visible');
  	// }
  });
// });
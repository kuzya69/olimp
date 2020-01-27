function addMouseScrollListener(obj, handler) {
    if (obj.attachEvent) {
        obj.attachEvent("onmousewheel", function(e){
            console.log("onmousewheel");
            console.log(e);
            // handler(e);
        }); // IE and Opera
    } else {
        obj.addEventListener("DOMMouseScroll", function(e){
            console.log("DOMMouseScroll");
            console.log(e);
            // handler(e);
        }, true); // FF
        obj.addEventListener("mousewheel", function(e){
            console.log("mousewheel");
            // console.log(e);
            handler(e);
        }, true); // Chrome
    }
}
var slider = document.querySelector(".slider-wrapper-main");
var sliderImgs = document.querySelector(".slider-wrapper-images");
var sliderImgsWidth = $(".slider-wrapper-images").width();
var sliderWidthBias = sliderImgsWidth;
var sliderDif = 205;
var sliderStart = 0;
function sliderWheel(event){
    var event = event || window.event;
    event.stopPropagation();
    event.preventDefault();

    // wheelDelta не даёт возможность узнать количество пикселей
    // eventdelta = null;
    var delta = null;
    if(!!event){
        // console.log(event);
        // console.log(event.originalEvent);
        delta = event.deltaY || event.detail || event.wheelDelta;
    }else{
        // console.log("нет eventa");
    }
    // console.log(delta);
    if(delta > 0){
        if(sliderStart <= (-sliderImgsWidth+(205))){
            sliderStart = 0;
            // sliderStart = sliderStart - sliderDif;
        }else{
            sliderStart = sliderStart - sliderDif;
        }
        sliderImgs.style.cssText = `left:`+sliderStart+`px`;
    }else if(delta < 0){
        if(sliderStart <= (-sliderImgsWidth+(205))){
            sliderStart = 0;
            // sliderStart = sliderStart - sliderDif;
        }else{
            sliderStart = sliderStart + sliderDif;
        }
        sliderImgs.style.cssText = `left:`+sliderStart+`px`;
    }else{
        console.log("колесо не крутилось!");
    }
    // if (event.originalEvent.wheelDelta) event.delta = event.originalEvent.wheelDelta / -40;
    // if (event.originalEvent.deltaY) event.delta = event.originalEvent.deltaY;
    // if (event.originalEvent.detail) event.delta = event.originalEvent.detail;

    // if (event.originalEvent.wheelDelta >= 0) {
    //     if(sliderStart <= (-sliderWidth)){
    //         sliderStart = 0;
    //         // sliderStart = sliderStart - sliderDif;
    //     }else{
    //         sliderStart = sliderStart - sliderDif;
    //     }
    //     sliderWidth.style.cssText = "left:"+sliderStart+"px";
    // }
    // else {
    //     if(sliderStart <= (-sliderWidth)){
    //         sliderStart = 0;
    //         // sliderStart = sliderStart - sliderDif;
    //     }else{
    //         sliderStart = sliderStart + sliderDif;
    //     }
    //     sliderWidth.style.cssText = "left:"+sliderStart+"px";
    // }
    console.log("slid: "+sliderStart);
}
// console.log(sliderWheel);
addMouseScrollListener(slider, sliderWheel);

// window.addEventListener('load',function(e){

//     console.log(e);
//     console.log("ok");
//     // alert('alert [10-33-12]');
// },true);
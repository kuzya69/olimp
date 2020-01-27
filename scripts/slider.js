function addMouseScrollListener(obj, handler) {
    if (obj.attachEvent) {
        obj.attachEvent("onmousewheel", handler(event)); // IE and Opera
    } else {
        obj.addEventListener("DOMMouseScroll", handler(event), false); // FF
        obj.addEventListener("mousewheel", handler(event), false); // Chrome
    }
}
var slider = document.querySelector(".slider-wrapper-main");
var sliderWidth = $(".slider-wrapper-images").width();
var sliderWidthBias = sliderWidth;
var sliderDif = 205;
var sliderStart = 0;
var sliderWheel = function(e){
    if (e.originalEvent.wheelDelta >= 0) {
        if(sliderStart <= (-sliderWidth)){
            sliderStart = 0;
            // sliderStart = sliderStart - sliderDif;
        }else{
            sliderStart = sliderStart - sliderDif;
        }
        sliderWidth.style.cssText = "left:"+sliderStart+"px";
    }
    else {
        if(sliderStart <= (-sliderWidth)){
            sliderStart = 0;
            // sliderStart = sliderStart - sliderDif;
        }else{
            sliderStart = sliderStart + sliderDif;
        }
        sliderWidth.style.cssText = "left:"+sliderStart+"px";
    }
    console.log("slid: "+sliderStart);
}
addMouseScrollListener(slider, sliderWheel);

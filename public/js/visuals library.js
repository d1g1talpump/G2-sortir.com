//animated search form
function animateElement(){
    $elementToAnimate = document.getElementById("search-form-field");
    $button = document.getElementById("show-hide-search-btn");
    if($elementToAnimate.style.height == "0px"){
        $elementToAnimate.animate([
            // keyframes
            { height: '0px' },
            { height: '80vh' }
        ], {
            // timing options
            duration: 500,
        });
        $elementToAnimate.style.height = '80vh';
        $button.textContent = "Close filters <<<"
    }else{
        $elementToAnimate.animate([
            // keyframes
            { height: '80vh' },
            { height: '0px' }
        ], {
            // timing options
            duration: 500,
        });
        $elementToAnimate.style.height = '0px';
        $button.textContent = "Open filters >>>"
    }
}
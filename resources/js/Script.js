//sticky nav
window.addEventListener("scroll",function(){
    var header = document.querySelector("header");
    header.classList.toggle("sticky",window.scrollY > 0);
})

	//Pre-next btn
    const TrendSlideContainer = [...document.querySelectorAll('.Tgame-container')];
    const nxtBtn = [...document.querySelectorAll('.next-btn')];
    const preBtn = [...document.querySelectorAll('.pre-btn')];
    
    TrendSlideContainer.forEach((item, i) =>{
    let containerDimensions = item.getBoundingClientRect();
    let containerWidth = containerDimensions.width;
    nxtBtn[i].addEventListener('click',() => {
        item.scrollLeft += containerWidth;
    })
    preBtn[i].addEventListener('click',() =>{
        item.scrollLeft -= containerWidth;
    })
    
    })


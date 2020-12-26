var observe;
var fireuiModal = document.getElementById("fireuiModal");
var fireuiBtn = document.getElementById("fireuiBtn");
var closeModal = document.getElementsByClassName("modal__closeBtn")[0];
var scrollTop_btn = document.getElementById("scrollTop");
var btnMode1 = document.querySelector(".btn__changeMode");
var currentTheme = localStorage.getItem("theme");
var form = document.getElementById('comment__form');
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function init() {
    function resize () {
        form.style.height = 'auto';
        form.style.height = form.scrollHeight+'px';
    }
    function delayedResize () {
        window.setTimeout(resize, 0);
    }
    observe(form, 'change',  resize);
    observe(form, 'cut',     delayedResize);
    observe(form, 'paste',   delayedResize);
    observe(form, 'drop',    delayedResize);
    observe(form, 'keydown', delayedResize);
    form.focus();
    form.select();
    resize();
}
document.addEventListener("DOMContentLoaded", function(){
	setTimeout(function(){
		document.body.classList.add('loaded');
	}, 500);
});
if(currentTheme == "dark"){
	document.body.classList.add("dark");
}
btnMode1.addEventListener("click", function(){
	document.body.classList.toggle("dark");
	let theme = "light";
	if(document.body.classList.contains("dark")){
		theme = "dark";
	}
	localStorage.setItem("theme", theme);
})
$('a[href*=\\#]').on('click', function(event){
    $('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
});
window.onscroll = function() {scrollButton()};
function scrollButton() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollTop_btn.style.display = "block";
  } else {
    scrollTop_btn.style.display = "none";
  }
}
function scrollToTop() {
	document.body.scrollTop = 0;
  	document.documentElement.scrollTop = 0;
}
function toggleNavbar() {
	var menu = document.getElementById("navbar__menu");
	if(menu.style.display === "block"){
		menu.style.display = "none";
	}else {
		menu.style.display = "block";
	}
}
fireuiBtn.onclick = function() {
	fireuiModal.style.display = "block";
}
closeModal.onclick = function() {
	fireuiModal.style.display = "none";
}
window.onclick = function(event){
	if(event.target == fireuiModal){ fireuiModal.style.display = "none"; }
}
var observe;
var scrollTop_btn = document.getElementById("scrollTop");
var btnMode1 = document.querySelector(".btn__changeMode");
var currentTheme = localStorage.getItem("theme");
var form = document.getElementById('comment__form');

var fireuiModal = document.getElementById("fireuiModal");
var fireuiBtn = document.getElementById("fireuiBtn");
var closeFireUI = document.getElementsByClassName("modal__closeFireUI")[0];

var chatAppModal = document.getElementById("chatAppModal");
var chatAppBtn = document.getElementById("chatAppBtn");
var closeChatApp = document.getElementsByClassName("modal__closeChatApp")[0];

var todoAppModal = document.getElementById("todoAppModal");
var todoAppBtn = document.getElementById("todoAppBtn");
var closeTodoApp = document.getElementsByClassName("modal__closeTodoApp")[0];

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
closeFireUI.onclick = function() {
	fireuiModal.style.display = "none";
}
chatAppBtn.onclick = function() {
	chatAppModal.style.display = "block";
}
closeChatApp.onclick = function() {
	chatAppModal.style.display = "none";
}
todoAppBtn.onclick = function() {
	todoAppModal.style.display = "block";
}
closeTodoApp.onclick = function() {
	todoAppModal.style.display = "none";
}
window.onclick = function(event){
	if(event.target == fireuiModal){ fireuiModal.style.display = "none"; }
	if(event.target == chatAppModal){ chatAppModal.style.display = "none"; }
	if(event.target == todoAppModal){ todoAppModal.style.display = "none"; }
}
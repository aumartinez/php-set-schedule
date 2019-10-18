var counter = 0;
var keyName;
var values=[];
var nodes = [];

function run(){
	
	addCompId();
	addaccuserpass();
	checkaccuser();
	getcompdid();
	checkcompuser();
	addcompuserpass();
	
}

function addCompId(){
	var elem = document.getElementById("company");
	elem.addEventListener('keyup',addCompReg,false);		
}

function addCompReg(){
	var elemSource = document.getElementById("company");
	var elemTarget = document.getElementById("compdid");
  var str;
	var txt;
	
	str = elemSource.value;	
	str = str.trim();	
	str =	str.substr(0,str.indexOf(' '));
	txt = randChar(5);
	
	if (str.length > 0 ){
		str = str.toLowerCase();
		elemTarget.value = str + txt;
	}
	else{
		str = elemSource.value;	
		str = str.trim();	
		str = str.toLowerCase();
		elemTarget.value = str + txt;
	}
	
}


function addaccuserpass(){
	var elem = document.getElementById("genpass");
	var elempass = document.getElementById("accpass");
	
	elem.addEventListener('click',function(){setPass(elempass);},false);
}

function addcompuserpass(){
	var elem = document.getElementById("gencompuserpass");
	var elempass = document.getElementById("compuserpass");
		
	elem.addEventListener('click',function(){setPass(elempass)},false);
}

function setPass(elem){
	var pass = randChar(8);
			
	elem.value = pass;
	
}

//Generate random string

function randChar(len){
	var txt = "";
	var str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	
	for(var i = 0; i < len; i++){
		txt += str.charAt(Math.floor(Math.random()*str.length));
	}
	
	return txt;
}


function addEventListenerList(list, event, func){
	for (var i = 0, j = 1, len = list.length; i < len; i++, j++){
		list[i].addEventListener(event, func, false);
		nodes.push(j);
	}
}

function validateaccform(){
	var elem = document.getElementById("validateaccuser");
	var str = elem.innerHTML;
	
	if(str.length > 0){
		return false;
	}
	
}

function validatecompuserform(){
	var elem = document.getElementById("validatecompuser");
	var str = elem.innerHTML;
	
	if(str.length > 0){
		return false;
	}
	
}


function checkaccuser(){
	var elem = document.getElementById("accuser");
	elem.addEventListener("blur", reqvalidaccuser, false);	
}

function reqvalidaccuser(){	
	var elem = document.getElementById("accuser");
	var str = elem.value;
	
	if(str.length === 0){
		document.getElementById("validateaccuser").innerHTML = "";
		return;
	}
	
	else{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					document.getElementById("validateaccuser").innerHTML = xmlhttp.responseText;
				}
			}
		
		xmlhttp.open("GET", "inc/cont-checkaccuser.php?usr=" + str, true);
		xmlhttp.send();		
	}
	
	str = document.getElementById("validateaccuser").innerHTML;
	
	if(str.length > 0){
		
		var btn = document.getElementById("btn-saveaccuser");
		disableBtn(btn);
	
	}
	
}

function getcompdid(){
	var elem = document.getElementById("addcomplist");
	
	if(elem){
		elem.addEventListener("blur", getcompdidreg, false);	
	}
}

function getcompdidreg(){	
	var elem = document.getElementById("addcomplist");
	var str = elem.value;
	
	if(str.length === 0){
		document.getElementById("addcompdid").value = "";
		return;
	}
	
	else{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					document.getElementById("addcompdid").value = xmlhttp.responseText;
				}
			}
		
		xmlhttp.open("GET", "inc/cont-getcompdid.php?comp=" + str, true);
		xmlhttp.send();		
	}
	
	
}

function checkcompuser(){
	var elem = document.getElementById("addcompuser");
	if(elem){
	 elem.addEventListener("blur", reqvalidaccuser, false);	
	}
	
}

function reqvalidaccuser(){	
	var elem = document.getElementById("addcompuser");
	var str = elem.value;
	
	if(str.length === 0){
		document.getElementById("validatecompuser").innerHTML = "";
		return;
	}
	
	else{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					document.getElementById("validatecompuser").innerHTML = xmlhttp.responseText;
				}
			}
		
		xmlhttp.open("GET", "inc/cont-checkcompuser.php?usr=" + str, true);
		xmlhttp.send();		
	}
	
	str = document.getElementById("validatecompuser").innerHTML;
	
	if(str.length > 0){
		
		var btn = document.getElementById("btn-savecompuser");
		disableBtn(btn);
	
	}
	
	
}


function disableBtn(btn){
	btn.style = "cursor:not-allowed";
}


window.addEventListener("load", run, false);

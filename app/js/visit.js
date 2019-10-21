var counter = 0;
var keyName;
var values=[];

window.addEventListener("load", run, false);

function run(){  
  additem();
}

function additem(){  
  document.getElementById("add-guest").addEventListener('click',addLi,false);   
}

function addLi(){
  var maxLi = 6;
  var liCount;
  
  var ul = document.getElementById("guest-list");//get ul element
  
  liCount = ul.childNodes.length;
  
  var li = document.createElement('li');  
  
  if(sessionStorage){
    counter = sessionStorage.getItem('counter');
    counter = parseInt(counter);
    if(!counter){
      counter = 0;
    }
  }
  
  counter++;  
  sessionStorage.setItem('counter',counter);
  //alert(counter);

  var deleteClick = '<a href="javascript:void(0);" id="item-'+ counter +'" onclick="deleteLi(this.id);" class="delete red-text"><i class="fa fa-times-circle" aria-hidden="true"></i></a>';
  var newname = '<input id="name-'+ counter +'" type="text" name="names[]" class="form-control" placeholder="Nombres y Apellidos" required>';
  var newcompany = '<input id="company-'+ counter +'" type="text" name="companies[]" class="form-control" placeholder="Nombre de la compañía" required/>';
  var newid = '<input id="personal-'+ counter +'" type="text" name="personalids[]" class="form-control" placeholder="Cedula de identidad" required/>';
  var visitor = '<input id="visitor-'+ counter +'" type="hidden" name="visitortype[]" value="guest"/>';
  //var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  
  li.innerHTML = '<span class="sub-wrapper">' + newname + newcompany + newid + visitor  +'</span>' + deleteClick;    
  
  if(maxLi > liCount){
    ul.appendChild(li);    
  }
  
}


function deleteLi(btnName){
  var ul = document.getElementById("guest-list");
  var a = document.getElementById(btnName);
  var li = a.parentNode;
  
  ul.removeChild(li);
}

function thischecked(id){
  var company = "company-"+id;
  var auth = "auth-"+id;
  var visitortype = "visitortype-"+id;
  
  if(document.getElementById(company).checked === true){
    document.getElementById(company).checked = false;
    document.getElementById(auth).checked = false;
    document.getElementById(visitortype).checked = false;
  }
  else{
    document.getElementById(company).checked = true;
    document.getElementById(auth).checked = true;
    document.getElementById(visitortype).checked = true;
  }  
}

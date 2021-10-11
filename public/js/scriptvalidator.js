// JavaScript Document

//var page = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname + "/";
//var page = window.location.protocol + "://" + window.location.host + "/";
var page="http://localhost/kahawa/inventorysystem/";
function paging(pageno,totpage,divename)
{
//alert (pageno)
//document.getElementById('userpassboth').style.display='none';
for(i=1; i<=totpage; i++)
{
var loc=divename+i;
document.getElementById(loc).style.display='none';
}
var loc=divename+pageno;
document.getElementById(loc).style.display='block';

}



function GetXmlHttpObject()
{
  var xmlHttp=null;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
  return xmlHttp;
}


function displayerrors(str)
{

document.getElementById('errors').style.display='block';
xmlHttp1=GetXmlHttpObject()
if (xmlHttp1==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 

    xmlHttp1.onreadystatechange=function()
      {
      if(xmlHttp1.readyState==4)
        {
        document.getElementById("errors").innerHTML=xmlHttp1.responseText;
		//loadbranchlist(str);
        }
      }
	  
    xmlHttp1.open("GET",page+"common/printerr/"+str,true);
	  xmlHttp1.send(null);
}
function displayerrorsnew(str,place)
{
	//alert(place);

//document.getElementById('errors').style.display='block';
xmlHttp1=GetXmlHttpObject()
if (xmlHttp1==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 

    xmlHttp1.onreadystatechange=function()
      {
      if(xmlHttp1.readyState==4)
        {
        document.getElementById(place).innerHTML=xmlHttp1.responseText;
		//loadbranchlist(str);
        }
      }
	  
    xmlHttp1.open("GET",page+"common/printerr/"+str,true);
	  xmlHttp1.send(null);
}


function popupdetails(pagenew,value,location)
{
//alert(page+pagenew+"/"+value);
	document.getElementById(location).style.display='block';
	//loader("search");
xmlHttp1=GetXmlHttpObject()
if (xmlHttp1==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 

    xmlHttp1.onreadystatechange=function()
      {
      if(xmlHttp1.readyState==4)
        {
        document.getElementById(location).innerHTML=xmlHttp1.responseText;
		//loadbranchlist(str);
		var flag=false;
		 for(z=0;z<document.forms.length;z++){
		  var form = document.forms[z];
		  var elements = form.elements;
		  for (var i=0;i<elements.length;i++){
			var element = elements[i];
			if(element.type == 'text' &&
			  !element.readOnly &&
			  !element.disabled){
			  //element.focus();
			  flag=true;
			 break;
			}
		  }
		  if(flag)break;
		 }
        }
      }
	  
    xmlHttp1.open("GET",page+pagenew+"/"+value,true);
	  xmlHttp1.send(null);
}





function  loader(location)
{
 //document.getElementById('view').innerHTML="<img src='images/ajax-loader.gif' />";
}


 function delconfirm(url) {
		if ( confirm ( "Are you sure you want to delete ?" ) )
		window.location=url;
	}
	function confirmDel(url){
var con= confirm('Are you sure to delete this record !');
	if(con){
		window.location=url;
	}
}

function Validatedesimal(obj,event){

		//alert("hello");
		if( (event != 46) && (event < 48 || event > 57)){ 
		//	alert("1");
			return false;
		}	
		if(obj.value.indexOf('.')!=(-1) && event==46){	 
			//alert("2");
			return false;
		}
	
		if(event!=46){
			if(obj.value.indexOf('.')!=(-1)){
				if(obj.value.substr(obj.value.indexOf('.')).length>2){
					//alert("3");
					return false;
				}
			}else{
		      if(obj.value.length>13){
                 //alert("4");
                 return false; 
			  }
		    }
		}
			return true;
	}
function validateQty(obj)
{
	
	var code="";
    var pattern = /\d\d\d\d\d\d\d\d\d\V|X|Z|v|x|z/;
                var id=obj.value;
                            
                if ((id.length == 0))
				{
                code='Quantity cannot be empty';
				 //obj.focus();
				}
                else if ((id.match(pattern) == null) || (id.length != 10))
				{
       				//alert(' Please enter a valid NIC.\n');
					code='Invalid Quantity';
					
				}
				
return code;
}

// JavaScript Document

function printpage()
{ window.print();
}
//---------------TaskTable SalesmanTable ZipLookup ZipTable Focus---------------->
function setFocus()
{ document.getElementById("Search").focus();
}

//Return ip address of the visitor not used
function ipadress()
{ return $_SERVER["REMOTE_ADDR"];
}

//function mailpopup()
//{ if (document.getElementById("emailbutton").value == "") {
//alert("Please enter a email adress");
//return false;
//} else
//return true;
//}

//---------------VendorTable VenderEdit Profession---------------->
function favProfession()
{ var SelectProfession=document.getElementById("SelectProfession");
document.getElementById("Profession").value=SelectProfession.options[SelectProfession.selectedIndex].text;
}

//---------------CustEdit and LeadEdit Googlemaps---------------->
function MM_goToURL() 
{ var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
 for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'"); }
 
//-----------CustTable Reload----------------------*/
function reloadProd(form)  
{ var val=form.SelectProd.options[form.SelectProd.options.selectedIndex].value ;
self.location='CustTable.php?ProdNo=' + val ;
}

function reloadSale(form)    
{ var val=form.SelectSaleman.options[form.SelectSaleman.options.selectedIndex].value ;
self.location='CustTable.php?SaleNo=' + val ; 
}

//---------------Leadtable reload?????---------------->
function reloadAds(form)    
{ var val=form.SelectAd.options[form.SelectAd.options.selectedIndex].value ;
self.location='LeadTable.php?AdNo=' + val ; 
}

function reloadLeadSale(form)    
{ var val=form.SelectSaleman.options[form.SelectSaleman.options.selectedIndex].value ;
self.location='LeadTable.php?SaleNo=' + val ; 
}

//-----------CustTable and LeadTable and VendorTable and ZipLookup RegLoginTable-------*/
function favState()
{ var SelectState=document.getElementById("SelectState");
document.getElementById("Search").value=SelectState.options[SelectState.selectedIndex].text;
}

//---------------custinsert and CustEdit Rate---------------->
function favRate()
{ var selectrate=document.getElementById("selectrate");
 document.getElementById("Rate").value=selectrate.options[selectrate.selectedIndex].text; }
 
 function favContractor()
{ var selectrate=document.getElementById("selectcontractor");
 document.getElementById("Contractor").value=selectcontractor.options[selectcontractor.selectedIndex].value; }
 
//---------------leadinsert radiogroup phone---------------->
function check(RadioGroup1)
{ document.getElementById("Phone").value=RadioGroup1 }

//---------------new lead and customer function on geting hints from getHint---------------->
function showHint(str)
{
if (str.length==0)
  { 
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","GetHint.php?q="+str,true);
xmlhttp.send();
}

//---------------new lead and customer function on geting zip code from getzip---------------->
function showZip(str)
{
if (str=="")
  {
  document.getElementById("State").innerHTML="";
  document.getElementById("Zip_Code").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
var string = xmlhttp.responseText;
var array = string.split(',');
document.getElementById("State").value=array[0];
document.getElementById("Zip_Code").value=array[1];
    }
  }
xmlhttp.open("GET","Getzip.php?q="+str,true);
xmlhttp.send();
}

//---------------Custedit getrepeat---------------->
function showRepeat(str)
{
if (str=="")
  {
  document.getElementById("txtrepeat").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtrepeat").innerHTML=xmlhttp.responseText;
    }
  }
var x=document.getElementById("Repeat").selectedIndex;
var y=document.getElementById("Repeat").options;
// var x=document.getElementById("Repeat"); 
// var text_value = x.options[x.selectedIndex].text;
if ( y[x].index == 1) {
xmlhttp.open("GET","Getrepeat.php?q="+str,true);
 } 
if ( y[x].index == 2) {
xmlhttp.open("GET","GetrepeatTotal.php?q="+str,true);
 }
if ( y[x].index == 3) {
xmlhttp.open("GET","GetrepeatAddressCust.php?q="+str,true);
 }
xmlhttp.send();
}

//---------------Leadedit getrepeat Lead---------------->
function showRepeatLead(str)
{
if (str=="")
  {
  document.getElementById("txtrepeat").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtrepeat").innerHTML=xmlhttp.responseText;
    }
  }
var x=document.getElementById("RepeatLead").selectedIndex;
var y=document.getElementById("RepeatLead").options;
// var x=document.getElementById("Repeat"); 
// var text_value = x.options[x.selectedIndex].text;
if ( y[x].index == 1) {
xmlhttp.open("GET","GetrepeatLeads.php?q="+str,true);
 } else {
xmlhttp.open("GET","GetrepeatAddress.php?q="+str,true);
 }
xmlhttp.send();
}





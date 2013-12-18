function SetLoading(div) { $("#"+div+"").html('<img src="img/ajax-loader.gif" alt="ajax-loader" border="0" style="vertical-align:middle;"> <i>Loading...</i>'); }
function SetLoading2(div) { $("#"+div+"").html('<br><hr color="#dddddd" size="1"><img src="img/ajax-loader.gif" alt="ajax-loader" border="0" style="vertical-align:middle;"> <i>Loading...</i>'); }
function load(file, target) { SetLoading(target); $("#"+target).load(file); }
function load2(file, target) { SetLoading2(target); $("#"+target).load(file); }
function LoadPopup(file, title, width) { $("#popup_wnd").css("visibility", "visible"); $("#popup_cont").css("visibility", "visible"); $("#ptitle").html(title); if(width == false) width=500;  $("#pdata").css("width", width); SetLoading('pdata'); $("#pdata").load(file); }
function Close() { $("#close").click(); }

function list_stuff(dvname, aname) {
  var dv = document.getElementById(dvname);
  var ael = document.getElementById(aname);
  if (ael.innerHTML == '+') {
    ael.innerHTML = '-';
    dv.style.display = 'block';
  }
  else {
    ael.innerHTML = '+';
    dv.style.display = 'none';
  }
}

var gAlrmElts = new Array();
function displayAlrmElts ()
{
  for (var i = 0; i < gAlrmElts.length; i++) {
    if (!gAlrmElts[i]) continue;
    (gAlrmElts[i].style.backgroundColor != "red") ? gAlrmElts[i].style.backgroundColor = "red" : gAlrmElts[i].style.backgroundColor = "black";
  }
  setTimeout("displayAlrmElts()", 333);
}
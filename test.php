<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<style type="text/css">
#preload {display:none; border:1px solid #71A4D0; width:200px; text-align:center; position:absolute; left:50%;margin-left:-100px; top:50%; margin-top:-50px;}
#preload p {margin:1px; padding:10px; border:1px solid #71A4D0;}
#preload img {margin-top:10px; margin-bottom: 10px;}
</style>
<script type="text/javascript">
function ShowHide(EltId,Action) {
var elt = document.getElementById(EltId); if (!elt) return;
Action = (typeof Action=="undefined" ) ? "" : Action.substring(0,1).toLowerCase();
with(elt.style) {
display = (Action=="" ) ? (display=="block" || display=="" ) ? "none" : "block" : (Action=="h" ) ? "none" : "block";
   }
}

</script>
</head>
<body onload="ShowHide('preload','h')">
<div id="preload">
<p>Pr&eacute;chargement<br>
<img src="loading.gif" width="96" height="19"><br>
 Veuillez patienter...<img src="images/loading6yt.gif" width="96" height="19">
</p>
</div>
<script>ShowHide('preload','s');</script>
<p>mon contenu</p>
</body>
</html>
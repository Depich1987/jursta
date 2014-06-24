//added by Franck Janel Agah ,24 june 2014 9h52 AM
function closeModalWindow(fen){
	fen.close();
}


// JavaScript Document
function ouvre_popup(page,l,h)
{
	var larg=(screen.width);
	var haut=(screen.height);
	larg=parseInt((larg-l)/2);
	haut=parseInt((haut-h)/2)
//	fen=window.showModalDialog(page,this,"dialogWidth:"+l+"px;dialogHeight:"+h+"px;center:Yes;scroll:No;help:No;status:No");
	var fen = window.open(page,"Popup","width="+l+",height="+h+",location=no,statut=no,toolbar=no,scrollbars=no,left="+larg+",top="+haut+",resizable=no")
//	fen=window.showModelessDialog(page,this,"dialogWidth:"+l+"px;dialogHeight:"+h+"px;center:1;scroll:0;help:0;status:0");
//	fen.close();
}
function confirmdelete(msg){
return confirm(msg);
}
function rechargerpage(page)
{
	window.close;
	opener.location.replace(page)
	opener.location.reload();
	window.opener=self;
//	self.close;
//	fen.close();	
}
function afficher(obj){
	document.getElementById(obj).style.display = "block";
	document.getElementById(obj).style.visibility = "visible";
	
}
function cacher(obj){
	document.getElementById(obj).style.display = "none";
	document.getElementById(obj).style.visibility = "hidden";
}

function afficher_autre(obj,condition,valeur){

	if (document.getElementById(condition).value==valeur) {
		document.getElementById(obj).style.display = "block";
		document.getElementById(obj).style.visibility = "visible";
	}
	else {
		cacher(obj)
	}
}
/*
function donnerdate(obj){
	document.getElementById(obj).value
}
*/

function chargement(){
   document.getElementById('chargement').style.display='none';
 //  document.getElementById('site').style.visibility='visible';
}

function extentionfile(extinputname,extoutputname) {	
	var filename=extoutputname.value;
	if (filename!="") {
		var terme=".";
		extention=filename.split(terme)
		document.getElementById(extinputname).value=extention[extention.length-1];		
	}
}

function afficherStatus( nom, numero,image )
		{
			var divID = nom + numero;
			var imageID = image + numero;
			if ( document.getElementById && document.getElementById( divID ) ) // Pour les navigateurs récents
				{
					Pdiv = document.getElementById( divID );
					PcH = true;
		 		}
			else if ( document.all && document.all[ divID ] ) // Pour les veilles versions
				{
					Pdiv = document.all[ divID ];
					PcH = true;
				}
			else if ( document.layers && document.layers[ divID ] ) // Pour les très veilles versions
				{
					Pdiv = document.layers[ divID ];
					PcH = true;
				}
			else
				{
					
					PcH = false;
				}
			if ( PcH )
				{
					if (Pdiv.className == 'cachediv') {
					 Pdiv.className = '';
					 document.getElementById( imageID ).src="images/VST01600.gif";
					}
				}
		}
		


function DivStatus( nom, numero,image )
		{
			var divID = nom + numero;
			var imageID = image + numero;
			if ( document.getElementById && document.getElementById( divID ) ) // Pour les navigateurs récents
				{
					Pdiv = document.getElementById( divID );
					PcH = true;
		 		}
			else if ( document.all && document.all[ divID ] ) // Pour les veilles versions
				{
					Pdiv = document.all[ divID ];
					PcH = true;
				}
			else if ( document.layers && document.layers[ divID ] ) // Pour les très veilles versions
				{
					Pdiv = document.layers[ divID ];
					PcH = true;
				}
			else
				{
					
					PcH = false;
				}
			if ( PcH )
				{
					if (Pdiv.className == 'cachediv') {
						Pdiv.className = '';
						document.getElementById( imageID ).src="images/VST01600.gif";
					}
					else {
					 Pdiv.className = 'cachediv';
					 document.getElementById( imageID ).src="images/VST01605.gif";
					}
				}
		}
		
	/*
	* Cache tous les divs ayant le même préfixe
	*/
	function CacheTout( nom, image )
		{	
			var NumDiv = 1;
			if ( document.getElementById ) // Pour les navigateurs récents
				{
					while ( document.getElementById( nom + NumDiv) )
						{
							SetDiv = document.getElementById( nom + NumDiv );					
							if ( SetDiv && SetDiv.className != 'cachediv' )
								{
									alert(Setimage);
									DivStatus( nom, NumDiv, image );
								}
							NumDiv++;
						}
				}
			else if ( document.all ) // Pour les veilles versions
				{
					while ( document.all[ nom + NumDiv ] )
						{
							SetDiv = document.all[ nom + NumDiv ];
							if ( SetDiv && SetDiv.className != 'cachediv' )
								{
									document.getElementById(Setimage).src="/images/VST01605.gif";
									DivStatus( nom, NumDiv, image );
								}
							NumDiv++;
						}
				}
			else if ( document.layers ) // Pour les très veilles versions
				{
					while ( document.layers[ nom + NumDiv ] )
						{
							SetDiv = document.layers[ nom + NumDiv ];
							if ( SetDiv && SetDiv.className != 'cachediv' )
								{
									DivStatus( nom, NumDiv, image );
								}
							NumDiv++;
						}
				}
		}
		

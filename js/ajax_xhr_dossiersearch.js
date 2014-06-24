/**
 * Lister les ecole d'une region avec un objet
 * XMLHTTPRequest.
 */
/* Cr&eacute;ation de la variable globale qui contiendra l'objet XHR */
var requete = null;
/**
 * Fonction priv&eacute;e qui va cr&eacute;er un objet XHR.
 * Cette fonction initialisera la valeur dans la variable globale d&eacute;finie
 * ci-dessus.
 */
function creerRequete()
{
    try
    {
        /* On tente de cr&eacute;er un objet XmlHTTPRequest */
        requete = new XMLHttpRequest();
    }
    catch (microsoft)
    {
        /* Microsoft utilisant une autre technique, on essays de cr&eacute;er un objet ActiveX */
        try
        {
            requete = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch(autremicrosoft)
        {
            /* La premi�re m&eacute;thode a &eacute;chou&eacute;, on en teste une seconde */
            try
            {
                requete = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch(echec)
            {
                /* � ce stade, aucune m&eacute;thode ne fonctionne... mettez donc votre navigateur � jour ;) */
                requete = null;
            }
        }
    }
    if(requete == null)
    {
        alert('Impossible de cr&eacute;er l\'objet requ�te,\nVotre navigateur ne semble pas supporter les objects XMLHttpRequest.');
    }
}
/**
 * Fonction priv&eacute;e qui va mettre � jour l'affichage de la page.
 */
function actualiser(iddiv,param)
{	

    var contenu = requete.responseText;        
    var block = document.getElementById(iddiv);
    block.innerHTML = contenu;

}

/**
 * Fonction publique appel&eacute;e par la page affich&eacute;e.
 * Cette fonction va initialiser la cr&eacute;ation de l'objet XHR puis appeler
 * le code serveur afin de r&eacute;cup&eacute;rer les donn&eacute;es � modifier dans la page.
 */
function getBlock(param,iddiv,page)
{ 
    /* Si il n'y a pas d'identifiant de localit&eacute;, on fait dispara�tre la seconde liste au cas o� elle serait affich&eacute;e */
    if(param == '')
    {
        document.getElementById(iddiv).innerHTML = '';
    }
    else
    {
        /* � cet endroit pr&eacute;cis, on peut faire appara�tre un message d'attente */
        var block = document.getElementById(iddiv);
        block.innerHTML ="<img src='images/loading' />" //Traitement en cours, veuillez patienter...";
        /* On cr&eacute;e l'objet XHR */
        creerRequete();
        /* D&eacute;finition du fichier de traitement */
        var url = page+"?"+param;
//		alert(param.substr(5,1));
        /* Envoi de la requ�te � la page de traitement */
        requete.open('GET', url, true);
        /* On surveille le changement d'&eacute;tat de la requ�te qui va passer successivement de 1 � 4 */
        requete.onreadystatechange = function()
        {
            /* Lorsque l'&eacute;tat est � 4 */
            if(requete.readyState == 4)
            {
                /* Si on a un statut � 200 */
                if(requete.status == 200)
                {
                    /* Mise � jour de l'affichage, on appelle la fonction apropri&eacute;e */
                    actualiser(iddiv,param);
                }
            }
        };
        requete.send(null);
    }
}
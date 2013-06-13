<?php
require "./config/est_autorise.php";
?>

<html>
<head>
	<title>WORDMIND</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<script type="text/javascript" src="jquery/jquery2.min.js"></script>
	<script type="text/javascript" src="jquery/jquery-ui.custom.min.js"></script>
	<link href="css/blitzer/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	<script>
	var motpropose;// mot que l'utilisateur soumet
	var motchoisi= ""; // mot choisi au hasard depuis la base de données
	var indice=""; // type du mot
	var tablecouleur = new Array(6);
	var nbreCoups = 0;
	var score = 15;
	var newScore;
	var utilisateur = {
       score : '<?php echo $utilisateur->getHighScore(); ?>',
       id : '<?php echo $utilisateur->getId(); ?>'
    }

	function initialisation(){ // fonction d'initialisation des champs
	$('input[name$="proposition"]').val('');
	$('input[name$="score"]').val(score);
	$('input[name$="nbCoups"]').val(nbreCoups);
	$('input[name$="memo1"]').val($('input[name$="memo1"]').val());
	$('input[name$="memo2"]').val($('input[name$="memo2"]').val());
	$('input[name$="memo3"]').val($('input[name$="memo3"]').val());
	$('input[name$="memo4"]').val($('input[name$="memo4"]').val());
	$('input[name$="memo5"]').val($('input[name$="memo5"]').val());
	$('input[name$="memo6"]').val($('input[name$="memo6"]').val());
}

	function verifMot(mot) {// Verifie que le mot que le mot est conforme à ce qu'on attend
	if (mot.length==6){
		var caracAutorises = "abcdefghijklmnopqrstuvwxyz";
		var cpt=0;
		for (i=0;i<=25;i++){
			if ((mot.split(""))[0]== caracAutorises.charAt(i)){
				cpt++;
			}
			if ((mot.split(""))[1]== caracAutorises.charAt(i)){
				cpt++;
			}
			if ((mot.split(""))[2]== caracAutorises.charAt(i)){
				cpt++;
			}
			if ((mot.split(""))[3]== caracAutorises.charAt(i)){
				cpt++;
			}
			if ((mot.split(""))[4]== caracAutorises.charAt(i)){
				cpt++;
			}
		}
		if (cpt!=5){
			alert("N'utilisez que des caractères non accentués !");
			return false;
		}
		else{
			return true;
		}
	}
	else{
		alert("Veuillez saisir un mot de 6 lettres s'il vous plait !");
		return false;
	}
}

	function jouerCoup(){ //fonction principale
		motpropose = $('input[name$="proposition"]').val();
		if (verifMot(motpropose)) {
			if (nbreCoups < 15){
				var tabC = mastermind(motchoisi, motpropose);
				a = document.getElementById('coupsA'+(nbreCoups+1));
				a.innerHTML = convertirMot(motpropose);
				b = document.getElementById('coupsB'+(nbreCoups+1));
				b.innerHTML = convertirCouleur(tabC);

				if (tabC[0]=="vert" && tabC[1]=="vert" && tabC[2]=="vert" && tabC[3]=="vert" && tabC[4]=="vert" && tabC[5]=="vert") {
					gagne();
				};
			}
			else {
				perdu();
			}
			nbreCoups++;
			score--;
			initialisation();
		}
	}
	function gagne()
	{
		$(function() {
			$( "#boite-win" ).dialog({
				height: 250,
				width:400,
				modal: true
			});
		});
		$('#spanScore').text(score);
		newScore = bestScore(score,utilisateur.score); //Récuppère le nouveau highScore
		//updateScore(changerScore); //Mettre à jour en AJAX le score
		updateScore(); //Mettre à jour en AJAX le score
	}
	function perdu()
	{
		$(function() {
			$( "#boite-loose" ).dialog({
				height: 250,
				width:400,
				modal: true
			});
		});
		$('#spanMot').text(motchoisi);
	}

	function bestScore (sc1,sc2) {
		if(sc1>sc2){
			return sc1;
		}
		else{
			return sc2;
		}
	}

	function mastermind(motmodele, mottest){ 
		var tabmodele=motmodele.split("");
		var tabtest=mottest.split("");
		var tabcouleurs= new Array(6);
		var i = 0;
		grossePorte = 0;
		while(i<tabtest.length){
			var porte = 0;
			var j = 0;
			while(j<tabmodele.length && (porte!=1)){
				if(tabtest[i]==tabmodele[i]){
					tabcouleurs[i] = "vert";
					porte=1;
				}
				else{
					var existe = new Boolean(false);
					for (var k = 0; k < tabmodele.length; k++) {
						if (tabtest[i] == tabmodele[k]) {
							tabcouleurs[i] = "orange";
							existe=true;
						}
					}
					if (existe== false){
						tabcouleurs[i] = "rouge";
					}
					j++;
					porte=1;
				}
			}
			i++;
		};
		return tabcouleurs;
	}

	function convertirMot(mot){ //prend une mot en entrée, retourne le code pour afficher les images des lettres pour former le mot
		var tab=mot.split("");
		var ligne = "";
		for (var i = 0; i < mot.length; i++) {
			ligne = ligne +'<img src="img/'+tab[i]+'.png">';
		};
		return(ligne);
	}
	function convertirCouleur(tab){ //convertir un tableau de caractères en couleurs
		var ligne = "";
		for (var i = 0; i < tab.length; i++) {
			ligne = ligne +'<img src="img/'+tab[i]+'.png">';
		};
		return ligne;
	}
	function genererTransp(){
		for (var i = 0; i < 6; i++) {
			document.write('<img src="img/vide.png">');
		};
	}

	function request(callback) {
		
		var xhr = new XMLHttpRequest(); //Instance d'un objet permettant une requète asynchrome

		xhr.onreadystatechange = function() { 
    			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) { // Vérifie si C'est bon, pas d'erreur de page 
												//inexistante (404, 500..)
    				  callback(xhr.responseText); // Fonction callback, pour alléger le code
    				}
    			};
		var nbLettres = 6; //document.nomSelect.value; //Récuppération du paramètre désiré
		xhr.open("GET","http://infolimon.iutmontp.univ-montp2.fr/~castaniet/wordmind/vues/acessData.php?nombre="+nbLettres,true); //Définitions des modalités d'envoi
		xhr.send(null); //Envoi de la requète
	}

	function recuppereMot(data) { //Traitement de l'info récupérée (info récupérée sous forme de texte avec le echo)

	var tabDefMot=data.split("@");
	motchoisi = tabDefMot[0];
	indice = tabDefMot[1];
	}

	function updateScore() //Autre manière (avec JQuery) pour écrire requète AJAX
		{
		$.ajax(
			{
			type: "GET",
			url: "http://infolimon.iutmontp.univ-montp2.fr/~castaniet/wordmind/vues/acessData.php",
			data: { user: utilisateur.id, score: newScore }
			}).done(function( msg )
			{
			newScorea = msg;
			});
		}


</script>
</head>
<body onload="initialisation();$( '#boite-win' ).hide();$( '#boite-loose' ).hide();request(recuppereMot);">
	<!-- <button onclick="request(recuppereMot);">Jouer</button> -->
	<div id="contenuJeu">
		<div style="height:2%;"></div>
		<div id="plateauJeu">
			<script type="text/javascript"></script>
			<div style="height:2%;"></div>
			<div id="proposition">
				Entrez un mot de 6 lettres: 
				<input type="text" size="16" maxlength="6" name="proposition" style="text-align:center">
				<button onclick="jouerCoup();" class="boutonRouge">Essayer ce mot</button> 
			</div>
			<div style="height:2%;"></div>
			<div id="memento">
				Mémo : 
				<input type="text" size="1" maxlength="1" name="memo1" style="text-align:center;margin-right:-6px;">
				<input type="text" size="1" maxlength="1" name="memo2" style="text-align:center;margin-right:-6px;">
				<input type="text" size="1" maxlength="1" name="memo3" style="text-align:center;margin-right:-6px;">
				<input type="text" size="1" maxlength="1" name="memo4" style="text-align:center;margin-right:-6px;">
				<input type="text" size="1" maxlength="1" name="memo5" style="text-align:center;margin-right:-6px;">
				<input type="text" size="1" maxlength="1" name="memo6" style="text-align:center;margin-right:-6px;">
			</div>
			<div id="boutons">
				<button onclick="alert('Ce mot est un ' +indice);" class="boutonRouge">Aide</button><br/>
				<button onclick="perdu();" class="boutonRouge">Donner sa langue au chat</button><br/>
				<button onclick="location.reload();" class="boutonRouge">Rejouer</button><br/>
				<a href="index.php?p=systeme_profil" class="boutonRouge">Accueil profil</a>
			</div>
			<div style="height:2%;"></div>
			<div id="score">
				<div>Nombre de coups joués : <input type="text" size="2" maxlength="2" name="nbCoups" style="text-align:center"> /15</div>
				<div>Votre score actuel : <input type="text" size="2" maxlength="2" name="score" style="text-align:center"></div>
			</div>
			<div id="explications">
				<p>Proposez un mot et cliquez sur le bouton "essayer".</p>
				<p>Une lumière verte <img src="img/vert.png"> signifie que la lettre entrée est bonne. Une orange <img src="img/orange.png"> signifie que la lettre est présente dans le mot, mais pas au bon endroit. Enfin, la lumière rouge <img src="img/rouge.png"> veut dire que cette lettre n'existe pas dans le mot.</p>
				<p>Vous pouvez abandonner à tout moment en donnant votre langue au chat pour voir le mot.</p>
				<p>Utilisez les cases du mémo pour stocker les lettres de votre choix !</p>
				<p>Si vous souhaitez entrer un é, écrivez un e. Idem pour les autres caractères spéciaux</p>
			</div>
			<div id="coups">
				<div id="coupsA">
					<div id="coupsA1">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA2">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA3">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA4">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA5">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA6">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA7">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA8">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA9">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA10">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA11">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA12">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA13">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA14">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsA15">
						<script type="text/javascript">genererTransp();</script>
					</div>
				</div>
				<div id="coupsB">
					<div id="coupsB1">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB2">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB3">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB4">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB5">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB6">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB7">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB8">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB9">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB10">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB11">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB12">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB13">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB14">
						<script type="text/javascript">genererTransp();</script>
					</div>
					<div id="coupsB15">
						<script type="text/javascript">genererTransp();</script>
					</div>
				</div>
			</div>

			<div id="boite-win" title="Gagné ! :-)">
				<p>Votre score est <span id="spanScore">?</span> </p>
				<p>Vous pouvez rejouer en cliquant sur le bouton</p>
				<button onclick="location.reload();" class="boutonRouge">Rejouer !</button>
			</div>

			<div id="boite-loose" title="Perdu  :-(">
				<p>Le mot caché était "<span id="spanMot">?</span>" ...</p>
				<p>Rejouez en cliquant sur le bouton</p>
				<button onclick="location.reload();" class="boutonRouge">Rejouer !</button>
			</div>
		</div>
	</div>
</body>
</html>

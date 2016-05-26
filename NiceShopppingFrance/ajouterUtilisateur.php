<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_ajouter.css" />
        <title>Ajouter un Employée</title>
    </head>

    <body>
    	<h1 style="text-align: center;">Ajouter un employé sur le Système d'information de Nice - Shopping France</h1>
    	<form method="post" action="connexion/traitement.php">
 
		   <fieldset>
		       	<legend id= "titre_legende">Votre identité</legend> <!-- Titre du fieldset --> 
		       	
		       	<!-- Choix de la civilité -->
		       	<select name="civilite" autofocus="autofocus" required="requierd">
		       		<option selected disabled>--- Civilité ---</option>
		       		<option value="madame">Madame</option>
		       		<option value="monsieur">Monsieur</option>
		       		<option value="mademoiselle">Mademoiselle</option>
		       	</select>

		       	<label for="nom">Votre nom : </label>
		       	<input type="text" name="nom" id="nom" autofocus="autofocus" required="requierd" placeholder="BA" /><br/>

		       	<label for="prenom">Votre prenom : </label>
		       	<input type="text" name="prenom" id="prenom" autofocus="autofocus" required="requierd" placeholder="Lamine" /><br/>

		       	<label for="dateNaissance">Votre date de naissance : </label>
		       	<input type="date" name="dateNaissance" id="dateNaissance" autofocus="autofocus" required="requierd" placeholder="28/12/1988" /><br/>

		       	<label for="numeroTelephone">Votre numéro de téléphone : </label>
		       	<input type="tel" name="numeroTelephone" id="numeroTelephone" autofocus="autofocus" required="requierd" placeholder="+33 6 51 58 75 08" /><br/>
		   	</fieldset>

		   	<!-- Adresse de résidence -->
		   	<fieldset>
		       	<legend id= "titre_legende">Votre adresse de résidence </legend> <!-- Titre du fieldset --> 

		       	<label for="numeroNomVoie">Numero et nom de la voie : </label>
		       	<input type="text" name="numeroNomVoie" id="numeroNomVoie" autofocus="autofocus" required="requierd" placeholder="1 Avenue Charles de Gaulle" /><br/>

		       	<label for="complementAdresse">Complément adresse : </label>
		       	<input type="text" name="complementAdresse" id="complementAdresse" autofocus="autofocus" placeholder="Ex : Chez M. DUPONT, Appart 46" /><br/>

		       	<label for="codePostale">Code Postale : </label>
		       	<input type="int" name="codePostale" id="codePostale" autofocus="autofocus" required="requierd" placeholder="75010" /><br/>

		       	<label for="ville">Ville : </label>
		       	<input type="text" name="ville" id="ville" autofocus="autofocus" required="requierd"  placeholder="Paris" /><br/>

		       	<label for="region">Region : </label>
		       	<input type="text" name="region" id="region" autofocus="autofocus" placeholder="Ile de France" /><br/>

		       	<label for="pays">Pays : </label>
		       	<input type="text" name="pays" id="pays" autofocus="autofocus" required="requierd" placeholder="France" /><br/>
		   	</fieldset>

		   	<!-- Information de connexion -->
		   	<fieldset>
		       	<legend id= "titre_legende">Vos informations de connexion </legend> <!-- Titre du fieldset --> 
		     
		       	<label for="emailFirst">saisir une adresse mail</label>
		       	<input type="email" name="emailFirst" id="emailFirst" autofocus="autofocus" required="requierd" placeholder="lamine.ba@niceshopping.fr" /><br/>
		       	
		       	<label for="emailSecond">Confirmer votre adresse mail</label>
		       	<input type="email" name="emailSecond" id="emailSecond" autofocus="autofocus" required="requierd" placeholder="lamine.ba@niceshopping.fr"/><br/>

		       	<label for="passwordFirst">Saisir un mot de passe</label>
		       	<input type="password" name="passwordFirst" id="passwordFirst" autofocus="autofocus" required="requierd"/><br/>

		       	<label for="passwordSecond">Confirmer votre mot de passe</label>
		       	<input type="password" name="passwordSecond" id="passwordSecond" autofocus="autofocus" required="requierd"/><br/>
		   	</fieldset>

		   	<!-- Votre Role -->
		   	<fieldset>
		       	<legend id= "titre_legende">Le rôle de l'utilisateur </legend> <!-- Titre du fieldset --> 
		     	<!-- Choix du role de l'utilisateur -->
		       	<select name="role" autofocus="autofocus" required="requierd">
		       		<option selected disabled>--- Rôle ---</option>
		       		<option value="administrateur">Administrateur</option>
		       		<option value="superUtilisateur">Super Utilisateur</option>
		       		<option value="directeurGeneral">Directeur général</option>
		       		<option value="employeeCoordination">Employé de coordination</option>
		       		<option value="livreur">Livreur</option>
		       		<option value="client">Client</option>

		       	</select>
		       	
		   	</fieldset>
		   	<input type="submit" value="Envoyer" ></code>

		</form>

    </body>
</html>
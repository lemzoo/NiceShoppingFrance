<?php

	//Inclure les fichiers utilisés
	include '../function/basic_function.php';
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=shopping_temp;charset=utf8', 'root', 'root');
	}catch(Exception $erreur){
	        die('Erreur : '.$erreur->getMessage());
	}

	//Creation des variables identités
	$civiliteUser = $_POST['civilite'];
	$nomUser = $_POST['nom'];
	$prenomUser = $_POST['prenom'];
	$dateNaissanceUser = $_POST['dateNaissance'];
	$numeroTelephoneUser = $_POST['numeroTelephone'];

	//Creation des variables adresse
	$numeroNomvoieUser = $_POST['numeroNomVoie'];
	$complementAdresseUser = $_POST['complementAdresse'];
	$codePostaleUser = $_POST['codePostale'];
	$villeUser = $_POST['ville'];
	$regionUser = $_POST['region'];
	$paysUser = $_POST['pays'];

	//Creation des variables de connexion
	$emailFirstUser = $_POST['emailFirst'];
	$emailSecondUser = $_POST['emailSecond'];
	$passwordFirstUser = $_POST['passwordFirst'];
	$passwordSecondUser = $_POST['passwordSecond'];

	//Creation des variables role
	$roleUser = $_POST['role'];

	$checkEmailAdress = isCharactereSame($emailFirstUser, $emailSecondUser); 
	$checkPassword = isCharactereSame($passwordFirstUser, $passwordSecondUser);
	
	$isEmailPasswordCorrect = $checkPassword AND $checkEmailAdress;
	
	$isEmailAddressExist = isEmailAddressExist($bdd, $emailFirstUser);
	
	
	echo 'checkEmailAdress = '.$checkEmailAdress.'</br>'; 
	echo 'checkPassword = '.$checkPassword.'</br>';
	echo 'isEmailPasswordCorrect = '.$isEmailPasswordCorrect.'</br>';
	echo 'isEmailAddressExist = '.$isEmailAddressExist.'</br>';

	$arrayUser[0] = $civiliteUser;
	$arrayUser[1] = $nomUser;
	$arrayUser[2] = $prenomUser;
	$arrayUser[3] = $dateNaissanceUser;
	$arrayUser[4] = $numeroTelepehoneUser;
	$arrayUser[5] = $roleUser;
	echo 'roleUser = '.$arrayUser[5].'</br>';
	
	$idPerson = insertUserData($bdd, $arrayUser);
	echo 'idPerson = '.$idPerson.'</br>';
	
	
	
	/*$arrayUser[0] = nomNumeroVoie
	$arrayUser[1] = complementAdresse
	$arrayUser[2] = codePostale
	$arrayUser[3] = ville
	$arrayUser[4] = region
	$arrayUser[5] = pays
	$arrayUser[6] = idUser*/
	
	
	//Insert data in the database 
	if ($isEmailAdressExist){
		echo "Cette adresse Email existe déjà dans notre base de donnée. </br>" ;
		echo "Merci de vérifier votre adresse mail </br>" ;
		header('Location: ajouterEmployee.php');
		exit();
	}
	else{
		//Insert data
		try{

			//First get the idRole corresponding to the role choosen
			$req = $bdd->prepare('SELECT idRole FROM role WHERE(nomRole = :choosenRole)');

			$req->execute(array(
				'choosenRole' => $roleUser
				));
		
			$data = $req->fetch();
			$req->closeCursor();
			$choosenRole = $data['idRole'];

			//Insert the User in the database
			$req = $bdd->prepare('INSERT INTO user(civiliteUser, nomUser, prenomUser, dateNaissanceUser, numeroTelephoneUser, roleUser) VALUES(:civiliteUser_, :nomUser_, :prenomUser_, :dateNaissanceUser_, :numeroTelephoneUser_, :roleUser_)');
			
			$req->execute(array(
						'civiliteUser_' 		=> $civiliteUser,
						'nomUser_' 				=> $nomUser,
						'prenomUser_' 			=> $prenomUser,
						'dateNaissanceUser_' 	=> $dateNaissanceUser,
						'numeroTelephoneUser_' 	=> $numeroTelephoneUser,
						'roleUser_' 			=> $choosenRole
						));
			$req->closeCursor();

			//get the user id inserted
			$req = $bdd->query('SELECT MAX(idUser) AS "lastUser" FROM user');
			
			$data = $req->fetch();
			$req->closeCursor();
			$idUserInserted = $data['lastUser'];

			//Insert the adresse of the user
			$req = $bdd->prepare('INSERT INTO adresse(numeroNomvoie, complementAdresse, codePostale, ville, region, pays, idUser) VALUES(:numeroNomvoie_, :complementAdresse_, :codePostale_, :ville_, :region_, :pays_, :idUser_)');
			
			$req->execute(array(
						'numeroNomvoie_' 	 => $numeroNomvoieUser,
						'complementAdresse_' => $complementAdresseUser,
						'codePostale_' 		 => $codePostaleUser,
						'ville_' 			 => $villeUser,
						'region_' 			 => $regionUser,
						'pays_' 			 => $paysUser,
						'idUser_'			 => $idUserInserted
						));
			$req->closeCursor();

			//Get the date of the day for the subscriber date

			$dateDuJour = getdate();
			$dateInscription = $dateDuJour['year'].'/'.$dateDuJour['mon'].'/'.$dateDuJour['mday'];

			echo "Date du jour : ". $dateInscription. '</br>';

			//Insert the data about the connection
			$req = $bdd->prepare('INSERT INTO connexion(adresseMailConnexion, motDePasseConnexion, dateInscriptionConnexion, idUserConnexion) VALUES(:adresseMailConnexion_, :motDePasseConnexion_, :dateInscriptionConnexion_, :idUserConnexion_)');
			
			$req->execute(array(
						'adresseMailConnexion_' 	=> $adresseMailUser,
						'motDePasseConnexion_' 		=> $passwordFirstUser,
						'dateInscriptionConnexion_' => $dateInscription,
						'idUserConnexion_' 			=> $idUserInserted
						));
			$req->closeCursor();

			//$data = $req->fetch();
			echo "Insert = " .$idUserInserted. "</br>";


			//header('Location: connexion.html');
	  		//exit();

		}catch(Exception $erreur){
		    die('Erreur : '.$erreur->getMessage());
		}

		echo ' civiliteUser = '. $civiliteUser. '</br>'.
			 ' nomUser = '. $nomUser. '</br>'.
			 ' prenomUser = '. $prenomUser. '</br>'.
			 ' dateNaissanceUser = ' . $dateNaissanceUser.  '</br>'.
			 ' numeroTelephoneUser = ' . $numeroTelephoneUser.  '</br>'.

			 ' numeroNomvoie = ' . $numeroNomvoieUser.  '</br>'.
			 ' complementAdresse = ' . $complementAdresseUser.  '</br>'.
			 ' codePostaleUser = ' . $codePostaleUser.  '</br>'.
			 ' villeUser = ' . $villeUser.  '</br>'.
			 ' regionUser= ' . $regionUser.  '</br>'.
			 ' paysUser= ' . $paysUser.  '</br>'.

			 ' emailFirstUser = ' . $emailFirstUser.  '</br>'.
			 ' emailSecondUser = ' . $emailSecondUser.  '</br>'. 
			 ' passwordFirstUser = ' . $passwordFirstUser.  '</br>'.
			 ' passwordSecondUser = ' . $passwordSecondUser.  '</br>'.

			 ' roleUser = ' . $roleUser.  '</br>'. 

			 ' checkEmailAdress = ' . $checkEmailAdress.  '</br>'.
			 ' checkPassword = ' . $checkPassword.  '</br>'.
			 ' checkEmailPassword = ' . $checkEmailPassword.  '</br>';
	 }
?>
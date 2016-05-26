<?php
	function sum($x, $y) {
		$z = $x + $y;
		return $z;
	}
	
	/*
	 * function isArrayContenEmpty() permet de verifier si le contenu 
	 * du tableau n'est pas vide. 
	 */
	function isArrayContenEmpty($array){
		$returnVal = true; 
		foreach ($array as $element){
			$returnVal = $returnVal AND (empty($element));
		}
		return !$returnVal; 
	}
	
	/*
	 * function isCharactereSame() permet de verififer si deux 
	 * chaines de caractètres sont identiques 
	 */
	function isCharactereSame($firstCharactere, $secondCharactere){
		$returnVal = false; 
		
		//verifions si les deux chaines ne sont pas vides. 
		if(empty($firstCharactere) && empty($secondCharactere)){
			$returnVal = false; 
		}
		else{
			//verifions si les deux caracteres sont identiques
			if ($firstCharactere == $secondCharactere){
				$returnVal = true; 
			}
			else{
				$returnVal = false;
			}
		}
		return $returnVal; 
	}
	
	/*
	 * function isEmailAddressExist() permet de vérifier si l'adresse
	 * email existe dans une base de donnée passé en paramètre
	 */
	function isEmailAddressExist($databaseName, $emailAddress){
		$returnVal = false; 
		
		try{
			$req = $databaseName->prepare('SELECT idUserConnexion FROM connexion WHERE 
							  				(adresseMailConnexion = :adresseMail))');
		
			$req->execute(array('adresseMail' => $emailAddress));
		
			$data = $req->fetch();
			$req->closeCursor(); 
			$returnVal = $data['idUserConnexion'];
		
		}catch(Exception $erreur){
			die('Erreur : '.$erreur->getMessage());
			$returnVal = false;
		}
		
		return $returnVal; 
	}
	
	/*
	 * function getTheUserRule() permet de récuperer l'identifiant
	 * du role de l'utilisateur en question. 
	 */
	
	function getTheUserRule($database, $rule){
		$returnVal = 0; 
		
		try{
			//Prepare the SQL requeste
			$req = $database->prepare('SELECT idRole FROM role WHERE(nomRole = :choosenRole)');
		
			$req->execute(array('choosenRole' => $rule));
		
			$data = $req->fetch();
			$req->closeCursor();
			$returnVal = $data['idRole'];
		
		}catch(Exception $erreur){
			die('Erreur : '.$erreur->getMessage());
			$returnVal = false;
		}
		
		return $returnVal; 
	}
	
	/*
	 * function insertUserData() permet d'inserer les informations de
	 * l'utilisateur en question contenu dans un tableau de la manière suivante
	 * array[0] = civiliteUser
	 * array[1] = nomUser
	 * array[2] = prenomUser
	 * array[3] = dateNaissanceUser
	 * array[4] = numeroTelepehoneUser
	 * array[5] = roleUser
	 */
	function insertUserData($database, $arrayUser){
		$returnVal = false;
		
		//Verifions si les données ne sont pas vide
		$isArrayEmpty = isArrayContenEmpty($arrayUser);
		
		if ($isArrayEmpty){
			$returnVal = 0;
		}
		else{
			//Extract the data in the array
			$civiliteUser 			= $arrayUser[0];
			$nomUser 				= $arrayUser[1];
			$prenomUser 			= $arrayUser[2];
			$dateNaissanceUser 		= $arrayUser[3];
			$numeroTelepehoneUser 	= $arrayUser[4];
			$roleUser 			  	= getTheUserRole($database, $arrayUser[5]);
			
			//Insert now the data in the table
			$req = $database->prepare('INSERT INTO user(civiliteUser, nomUser, prenomUser, dateNaissanceUser, numeroTelephoneUser, roleUser) VALUES(:civiliteUser_, :nomUser_, :prenomUser_, :dateNaissanceUser_, :numeroTelephoneUser_, :roleUser_)');
				
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
			$req = $database->query('SELECT MAX(idUser) AS "lastUser" FROM user');
				
			$data = $req->fetch();
			$req->closeCursor();
			$idUserInserted = $data['lastUser'];
			
			$returnVal = $idUserInserted;
		}
		return $returnVal;
	}
	
	/*
	 * function insertUserAddress() permet d'inserer l'adresse de résidence de 
	 * l'utilisateur en question contenu dans un tableau de la manière suivante
	 * array[0] = nomNumeroVoie
	 * array[1] = complementAdresse
	 * array[2] = codePostale
	 * array[3] = ville
	 * array[4] = region
	 * array[5] = pays
	 * array[6] = idUser
	 */
	/*function insertUserData($database, $arrayAddress){
		$returnVal = false;
	
		//Verifions si les données ne sont pas vide
		$isArrayEmpty = isArrayContentEmpty($arrayAddress);
	
		if ($isArrayEmpty){
			$returnVal = 0;
		}
		else{
			//Extract the data in the array
			$nomNumeroVoie 		= $arrayAddress[0];
			$complementAdresse 	= $arrayAddress[1];
			$codePostale 		= $arrayAddress[2];
			$ville 				= $arrayAddress[3];
			$region 			= $arrayAddress[4];
			$pays 			  	= $arrayAddress[5];
			$idUser 			= $arrayAddress[6];
				
			//Insert the adresse of the user
			$req = $database->prepare('INSERT INTO adresse(numeroNomvoie, complementAdresse, codePostale, ville, region, pays, idUser) VALUES(:numeroNomvoie_, :complementAdresse_, :codePostale_, :ville_, :region_, :pays_, :idUser_)');
			
			$req->execute(array(
				'numeroNomvoie_' 	 => $numeroNomVoie,
				'complementAdresse_' => $complementAdresse,
				'codePostale_' 		 => $codePostale,
				'ville_' 			 => $ville,
				'region_' 			 => $region,
				'pays_' 			 => $pays,
				'idUser_'			 => $idUser
			));
			$req->closeCursor();
			
			//get the user id inserted
			$req = $database->query('SELECT MAX(idAdresse) AS "lastAdresse" FROM adresse');
	
			$data = $req->fetch();
			$req->closeCursor();
			$lastAdresseInserted = $data['lastAdresse'];
				
			$returnVal = $lastAdresseInserted;
		}
		return $returnVal;
	}*/
	
	
	/*
	 * function insertUserConnexionData() permet d'inserer les informations de connexion 
	 * de l'utilisateur qu'est un adresse email et un mot de passe pour l'authentification.
	 * Ci-dessous la structure des données à insérer
	 * array[0] = adresseMail
	 * array[1] = password
	 * array[2] = idUser
	 * 
	 * La date d'inscription (date du jour) devra être rajouté. 
	 */

	/*function insertUserConnexionData($database, $arrayConnexion){
		$returnVal = 0;
	
		//Verifions si les données ne sont pas vide
		$isArrayEmpty = isArrayContentEmpty($arrayConnexion);
	
		if ($isArrayEmpty){
			$returnVal = 0;
		}
		else{
			//Extract the data in the array
			$adresseMail = $arrayAddress[0];
			$password 	 = $arrayAddress[1];
			$idUser 	 = $arrayAddress[2];
			
			//Récuperation de la date du jour 
			$dateDuJour = getdate();
			$dateInscription = $dateDuJour['year'].'/'.$dateDuJour['mon'].'/'.$dateDuJour['mday'];
			
			//Insert the data about the authentification of the user
			$req = $database->prepare('INSERT INTO connexion(adresseMailConnexion, motDePasseConnexion, dateInscriptionConnexion, idUserConnexion) VALUES(:adresseMailConnexion_, :motDePasseConnexion_, :dateInscriptionConnexion_, :idUserConnexion_)');
				
			$req->execute(array(
					'adresseMailConnexion_' 	=> $adresseMail,
					'motDePasseConnexion_' 		=> $password,
					'dateInscriptionConnexion_' => $dateInscription,
					'idUserConnexion_' 			=> $idUser
			));
			$req->closeCursor();
				
			//get the user id inserted
			$req = $database->query('SELECT MAX(idConnexion) AS "lastConnexion" FROM connexion');
	
			$data = $req->fetch();
			$req->closeCursor();
			$lastConnexionUser = $data['lastConnexion'];
	
			$returnVal = $lastConnexionUser;
		}
		return $returnVal;
	}*/	
?>
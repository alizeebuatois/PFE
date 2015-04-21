<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$now = new DateTime('today');
$currentYear = $now->format('Y');

$config = array(

				// Formulaire de connexion
				'user/login' => array(

					// Login / Adresse e-mail
					array(
							'field' => 'login',
							'label' => 'Login',
							'rules' => 'trim|required|xss_clean|max_length[255]'
				        ),
					// Mot de passe
					array(
							'field' => 'password',
							'label' => 'Mot de passe',
							'rules' => 'trim|required|user_loggable'
						)
					),


				// Formulaire d'inscription
				'subscribe' => array(

					// Civilité
					array(
							'field' => 'title',
							'label' => 'Civilité',
							'rules' => 'trim|required|xss_clean|max_length[5]'
						),
					// Prénom
					array(
							'field' => 'firstname',
							'label' => 'Prénom',
							'rules' => 'trim|required|xss_clean|max_length[30]'
						),
					// Nom
					array(
							'field' => 'lastname',
							'label' => 'Nom',
							'rules' => 'trim|required|xss_clean|max_length[30]'
					    ),
					// Date de naissance - Jour
					array(
							'field' => 'birthdate_day',
							'label' => 'Jour de naissance',
							'rules' => 'trim|required|xss_clean|integer|greater_than[0]|less_than[32]|exact_length[2]'
						),
					// Date de naissance - Mois
					array(
							'field' => 'birthdate_month',
							'label' => 'Mois de naissance',
							'rules' => 'trim|required|xss_clean|integer|greater_than[0]|less_than[13]|exact_length[2]'
					    ),
					// Date de naissance - Année
					array(
							'field' => 'birthdate_year',
							'label' => 'Année de naissance',
							'rules' => 'trim|required|xss_clean|integer|greater_than[0]|less_than['.($currentYear+1).']|exact_length[4]|is_adult'
					    ),
					// Ville de naissance
					array(
							'field' => 'birthcity',
							'label' => 'Ville de naissance',
							'rules' => 'trim|required|xss_clean|max_length[50]'
						),
					// Pays de naissance
					array(
							'field' => 'birth_country_id',
							'label' => 'Pays de naissance',
							'rules' => 'trim|required|xss_clean|greater_than[0]|less_than[252]'
						),
					// Adresse 1
					array(
							'field' => 'address1',
							'label' => 'Adresse',
							'rules' => 'trim|required|xss_clean'
						),
					// Complément adresse
					array(
							'field' => 'address2',
							'label' => 'Complément d\'adresse',
							'rules' => 'trim|xss_clean'
						),
					// Code postal
					array(
							'field' => 'postalcode',
							'label' => 'Code postal',
							'rules' => 'trim|required|xss_clean|numeric|exact_length[5]'
						),
					// Ville
					array(
							'field' => 'city',
							'label' => 'Ville',
							'rules' => 'trim|required|xss_clean|max_length[50]'
						),
					// Pays
					array(
							'field' => 'country_id',
							'label' => 'Pays',
							'rules' => 'trim|required|xss_clean|greater_than[0]|less_than[252]'
						),
					// Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email|is_unique[user.user_email]'
						),
					// Confirmation adresse e-mail
					array(
							'field' => 'email_confirm',
							'label' => 'Confirmation adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email|matches[email]'
						)
					),
				

				// Formulaire create user (METHODE RAPIDE POUR BACKEND)
				'user/create' => array(

					// checkboxes
					array(
							'field' => 'contact-checkbox',
							'label' => '',
							'rules' => 'trim|xss_clean'
						),
					array(
							'field' => 'birthplace-checkbox',
							'label' => '',
							'rules' => 'trim|xss_clean'
						),
					array(
							'field' => 'address-checkbox',
							'label' => '',
							'rules' => 'trim|xss_clean'
						),
                    // Civilité
                    array(
                            'field' => 'title',
                            'label' => 'Civilité',
                            'rules' => 'trim|required|xss_clean|max_length[5]'
                        ),
                    // Nom
                    array(
                            'field' => 'lastname',
                            'label' => 'Nom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Prénom
                    array(
                            'field' => 'firstname',
                            'label' => 'Prénom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Date de naissance
                    array(
                            'field' => 'birthdate',
                            'label' => 'Date de naissance',
                            'rules' => 'trim|required|xss_clean|exact_length[10]'
                        ),
					// Ville de naissance
					array(
							'field' => 'birthcity',
							'label' => 'Ville de naissance',
							'rules' => 'trim|xss_clean|max_length[50]'
						),
					// Pays de naissance
					array(
							'field' => 'birth_country_id',
							'label' => 'Pays de naissance',
							'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
						),
					// Adresse 1
					array(
							'field' => 'address1',
							'label' => 'Adresse',
							'rules' => 'trim|xss_clean'
						),
					// Complément adresse
					array(
							'field' => 'address2',
							'label' => 'Complément d\'adresse',
							'rules' => 'trim|xss_clean'
						),
					// Code postal
					array(
							'field' => 'postalcode',
							'label' => 'Code postal',
							'rules' => 'trim|xss_clean|numeric|exact_length[5]'
						),
					// Ville
					array(
							'field' => 'city',
							'label' => 'Ville',
							'rules' => 'trim|xss_clean|max_length[50]'
						),
					// Pays
					array(
							'field' => 'country_id',
							'label' => 'Pays',
							'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
						),
					// Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|xss_clean|valid_email|is_unique[user.user_email]'
						),
					// Confirmation adresse e-mail
					array(
							'field' => 'email_confirm',
							'label' => 'Confirmation adresse e-mail',
							'rules' => 'trim|xss_clean|valid_email|matches[email]'
						),
					// Téléphone
					array(
							'field' => 'phone',
							'label' => 'Téléphone',
							'rules' => 'trim|xss_clean|numeric|exact_length[10]'
						)
					),

				
				// Formulaire update ´user´
				'user/update' => array(

					// Variable cachée indiquant le POST
					array(
							'field' => 'post',
							'label' => 'POST',
							'rules' => 'trim|required|greater_than[0]|less_than[2]'
					    ),
					// Variable cachée indiquant la clé de l'utilisateur
					array(  
							'field' => 'user_key',
							'label' => 'USER_KEY',
							'rules' => 'trim|required|exact_length[10]'
					    ),
					// Nouveau mot de passe
					array(
							'field' => 'newpassword',
							'label' => 'Nouveau mot de passe',
							'rules' => 'trim|min_length[6]'
					    ),
					// Confirmation nouveau mot de passe
					array(
							'field' => 'newpassword_confirm',
							'label' => 'Confirmation nouveau mot de passe',
							'rules' => 'trim|matches[newpassword]'
					    ),
					// Adresse 1
					array(
							'field' => 'address1',
							'label' => 'Adresse',
							'rules' => 'trim|required|xss_clean'
					    ),
					// Complément adresse
					array(
							'field' => 'address2',
							'label' => 'Complément d\'adresse',
							'rules' => 'trim|xss_clean'
					    ),
					// Code postal
					array(
							'field' => 'postalcode',
							'label' => 'Code postal',
							'rules' => 'trim|required|xss_clean|numeric|exact_length[5]'
					    ),
					// Ville
					array(
							'field' => 'city',
							'label' => 'Ville',
							'rules' => 'trim|required|xss_clean|max_length[50]'
					    ),
					// Pays
					array(
							'field' => 'country_id',
							'label' => 'Pays',
							'rules' => 'trim|required|xss_clean|greater_than[0]|less_than[252]'
					    ),
					// Téléphone
					array(
							'field' => 'phone',
							'label' => 'Téléphone',
							'rules' => 'trim|xss_clean|numeric|exact_length[10]'
					    ),
					// Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email|user_unique_email'
					    ),
					// Confirmation adresse e-mail
					array(
							'field' => 'email_confirm',
							'label' => 'Confirmation adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email|matches[email]'
					    )
					),

				// Formulaire update ´user´ en Ajax (pour backend)
				'user/updateAjax' => array(

					// Variable cachée indiquant la clé de l'utilisateur
					array(  
							'field' => 'user_key',
							'label' => 'USER_KEY',
							'rules' => 'trim|xss_clean|required|exact_length[10]'
					    ),
					// Login
					array(
							'field' => 'login',
							'label' => 'Identifiant',
							'rules' => 'trim|xss_clean|required|alpha_numeric|min_length[5]'
						),
					// Adresse 1
					array(
							'field' => 'address1',
							'label' => 'Adresse',
							'rules' => 'trim|xss_clean'
					    ),
					// Complément adresse
					array(
							'field' => 'address2',
							'label' => 'Complément d\'adresse',
							'rules' => 'trim|xss_clean'
					    ),
					// Code postal
					array(
							'field' => 'postalcode',
							'label' => 'Code postal',
							'rules' => 'trim|xss_clean|numeric|exact_length[5]'
					    ),
					// Ville
					array(
							'field' => 'city',
							'label' => 'Ville',
							'rules' => 'trim|xss_clean|max_length[50]'
					    ),
					// Pays
					array(
							'field' => 'country_id',
							'label' => 'Pays',
							'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
					    ),
					// Téléphone
					array(
							'field' => 'phone',
							'label' => 'Téléphone',
							'rules' => 'trim|xss_clean|numeric|exact_length[10]'
					    ),
					// Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|xss_clean|valid_email|user_unique_email'
					    ),
					// User right
                    array(
                    		'field' => 'user_right',
                    		'label' => 'Droits',
                    		'rules' => 'trim|xss_clean|exact_length[1]|less_than[4]'
                    	)
					),
									
				// Formulaire update ´customer´
				'customer' => array(

                    // Variable cachée indiquant le POST
                    array(
                            'field' => 'post',
                            'label' => 'POST',
                            'rules' => 'trim|required|greater_than[0]|less_than[2]'
                        ),
                    // Variable cachée indiquant la clé de l'utilisateur
                    array(  
                            'field' => 'customer_key',
                            'label' => 'CUSTOMER_KEY',
                            'rules' => 'trim|required|exact_length[10]|alpha_numeric'
                        ),
                    // Civilité
                    array(
                            'field' => 'title',
                            'label' => 'Civilité',
                            'rules' => 'trim|required|xss_clean|max_length[5]'
                        ),
                    // Prénom
                    array(
                            'field' => 'firstname',
                            'label' => 'Prénom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Nom
                    array(
                            'field' => 'lastname',
                            'label' => 'Nom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Date de naissance - Jour
                    array(
                            'field' => 'birthdate_day',
                            'label' => 'Jour de naissance',
                            'rules' => 'trim|required|xss_clean|integer|greater_than[0]|less_than[32]|exact_length[2]'
                        ),
                    // Date de naissance - Mois
                    array(
                            'field' => 'birthdate_month',
                            'label' => 'Mois de naissance',
                            'rules' => 'trim|required|xss_clean|integer|greater_than[0]|less_than[13]|exact_length[2]'
                        ),
                    // Date de naissance - Année
                    array(
                            'field' => 'birthdate_year',
                            'label' => 'Année de naissance',
                            'rules' => 'trim|required|xss_clean|integer|greater_than[0]|less_than['.($currentYear+1).']|exact_length[4]|is_child'
                        ),
                    // Ville de naissance
                    array(
                            'field' => 'birthcity',
                            'label' => 'Ville de naissance',
                            'rules' => 'trim|required|xss_clean|max_length[50]'
                        ),
                    // Pays de naissance
                    array(
                            'field' => 'birth_country_id',
                            'label' => 'Pays de naissance',
                            'rules' => 'trim|required|xss_clean|greater_than[0]|less_than[252]'
                        ),
					// Age
                    array(
                    		'field' => 'age',
                    		'label' => 'Age',
                    		'rules' => 'trim|xss_clean|numeric|max_length[3]'
                    	),
                    // Poids
                    array(
                    		'field' => 'poids',
                    		'label' => 'Poids',
                    		'rules' => 'trim|xss_clean|numeric|max_length[3]'
                    	),
                    // Numéro de sécurité social
                    array(
                    		'field' => 'numsecu',
                    		'label' => 'Numéro de sécurité social',
                    		'rules' => 'trim|xss_clean|numeric|exact_length[15]'
                    	),
                    // Groupe sauguin
                    array(
                    		'field' => 'bloodgroup',
                    		'label' => 'Groupe sauguin',
                    		'rules' => 'trim|xss_clean|max_length[3]'
                    	)
                    ),

				// Formulaire create customer (METHODE RAPIDE POUR BACKEND)
				'customer/createFast' => array(

                    // Variable cachée indiquant la clé de l'utilisateur
                    array(  
                            'field' => 'user_key',
                            'label' => 'USER_KEY',
                            'rules' => 'trim|required|exact_length[10]|alpha_numeric'
                        ),
                    // Civilité
                    array(
                            'field' => 'title',
                            'label' => 'Civilité',
                            'rules' => 'trim|required|xss_clean|max_length[5]'
                        ),
                    // Prénom
                    array(
                            'field' => 'firstname',
                            'label' => 'Prénom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Nom
                    array(
                            'field' => 'lastname',
                            'label' => 'Nom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Date de naissance
                    array(
                            'field' => 'birthdate',
                            'label' => 'Date de naissance',
                            'rules' => 'trim|required|xss_clean|exact_length[10]'
                        )
                    ),

				// Formulaire update ´customer´
				'customer/updateAjax' => array(

                    // Variable cachée indiquant la clé de l'utilisateur
                    array(  
                            'field' => 'customer_key',
                            'label' => 'CUSTOMER_KEY',
                            'rules' => 'trim|required|exact_length[10]|alpha_numeric'
                        ),
                    // Civilité
                    array(
                            'field' => 'title',
                            'label' => 'Civilité',
                            'rules' => 'trim|required|xss_clean|max_length[5]'
                        ),
                    // Prénom
                    array(
                            'field' => 'firstname',
                            'label' => 'Prénom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Nom
                    array(
                            'field' => 'lastname',
                            'label' => 'Nom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),
                    // Date de naissance
                    array(
                            'field' => 'birthdate',
                            'label' => 'Date de naissance',
                            'rules' => 'trim|required|xss_clean|exact_length[10]'
                        ),
                    // Ville de naissance
                    array(
                            'field' => 'birthcity',
                            'label' => 'Ville de naissance',
                            'rules' => 'trim|xss_clean|max_length[50]'
                        ),
                    // Pays de naissance
                    array(
                            'field' => 'birth_country_id',
                            'label' => 'Pays de naissance',
                            'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
                        ),
					// Age
                    array(
                    		'field' => 'age',
                    		'label' => 'Age',
                    		'rules' => 'trim|xss_clean|numeric|max_length[3]'
                    	),
                    // Poids
                    array(
                    		'field' => 'poids',
                    		'label' => 'Poids',
                    		'rules' => 'trim|xss_clean|numeric|max_length[3]'
                    	),
                    // Numéro de sécurité social
                    array(
                    		'field' => 'numsecu',
                    		'label' => 'Numéro de sécurité social',
                    		'rules' => 'trim|xss_clean|numeric|exact_length[15]'
                    	),
                    // Groupe sauguin
                    array(
                    		'field' => 'bloodgroup',
                    		'label' => 'Groupe sauguin',
                    		'rules' => 'trim|xss_clean|max_length[3]'
                    	),
                   ),
           

				// Formulaire d'association de comptes
				'partnership/create' => array(

					// Login ou adresse e-mail
					array(
							'field' => 'login',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email|user_exists|partnership_not_self|partnership_unique'
						)
				),

				// Formulaire d'association de comptes (METHODE RAPIDE POUR BACKEND)
				'partnership/createFast' => array(

					// Login ou adresse e-mail
					array(
							'field' => 'user_a',
							'label' => 'Compte 1',
							'rules' => 'trim|required|xss_clean|user_exists'
						),
					array(
							'field' => 'user_b',
							'label' => 'Utilisateur',
							'rules' => 'trim|required|xss_clean|user_exists|partnership_not_self[user_a]|partnership_unique[user_a]'
						)
				),

				// Contact
				'contact' => array(

					// Nom
					array(
							'field' => 'lastname',
							'label' => 'Nom',
							'rules' => 'trim|required|xss_clean'
						),
					// Prénom
					array(
							'field' => 'firstname',
							'label' => 'Prénom',
							'rules' => 'trim|required|xss_clean'
						),
					// Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email'
						),
					// Sujet
					array(
							'field' => 'subject',
							'label' => 'Sujet',
							'rules' => 'trim|required|xss_clean'
						),
					// Message
					array(
							'field' => 'message',
							'label' => 'Message',
							'rules' => 'trim|required|xss_clean|min_length[150]'
						)
				),

				// Formulaire médical info
				'medicalinfo/update' => array(
					// Variable cachée indiquant la clé de l'utilisateur
                    array(  
                            'field' => 'customer_key',
                            'label' => 'CUSTOMER_KEY',
                            'rules' => 'trim|required|exact_length[10]'
                        ),
					// Grossesse en cours
                    array(
                            'field' => 'pregnancy',
                            'label' => 'Grossesse en cours',
                            'rules' => 'trim|xss_clean'
                        ),
					// Contraception
                    array(
                            'field' => 'contraception',
                            'label' => 'Contraception',
                            'rules' => 'trim|xss_clean'
						),
					// Allaitement
                    array(
                            'field' => 'breastfeeding',
                            'label' => 'Allaitement',
                            'rules' => 'trim|xss_clean'
                        ),
					// Assurance rapatriation
					array(
							'field' => 'repatriation',
							'label' => 'Assurance rapatriation',
							'rules' => 'trim|required|xss_clean'
						),
					// Intervention récente
					array(
							'field' => 'recentInterventionComment',
							'label' => 'Intervention récente',
							'rules' => 'trim|xss_clean|max_length[500]'
						),
					// Antécédents de réactions vaccinales
					array(
							'field' => 'previousVaccinReactionComment',
							'label' => 'Antécédents de réactions vaccinales',
							'rules' => 'trim|xss_clean|max_length[500]'
						),
					// Maladie aiguë ou fièvre récente
					array(
							'field' => 'diseaseOrRecentFeverComment',
							'label' => 'Maladie aiguë ou fièvre récente',
							'rules' => 'trim|xss_clean|max_length[500]'
						),
					// Traitement en cours
					array(
							'field' => 'currentTreatment',
							'label' => 'Traitements actuels',
							'rules' => 'trim|xss_clean|max_length[500]'
						)/*,
					// Mot de passe
                    array(
                            'field' => 'password',
                            'label' => 'Mot de passe',
                            'rules' => 'trim|required|user_check_password'
                        )*/
                 ),

				
				// Formulaire vaccins
				'vaccins/update' => array(

					// le nom du vaccin
					array(  
                            'field' => 'vaccinsNames[]',
                            'label' => 'Nom',
                            'rules' => 'trim|required|xss_clean|max_length[30]'
                        ),

					// le prix du vaccin
					array(  
                            'field' => 'vaccinsPrices[]',
                            'label' => 'Prix',
                            'rules' => 'trim|required|numeric'
                        ),

				),

				// Formulaire ajout de traitements
				'treatment/update' => array(

					// le nom du traitement
					array(
						    'field' => 'treatmentNames[]',
                            'label' => 'Nom',
                            'rules' => 'trim|required'
						),

						// le titre du traitement
					array(
						    'field' => 'treatmentTitles[]',
                            'label' => 'Titre',
                            'rules' => 'trim|required'
						),

					// la description du traitement
					array(
							'field' => 'treatmentDescriptions[]',
                            'label' => 'Description',
                            'rules' => 'trim'
						),

				),


				// Formulaire pour ajouter des lots dans Stock
				'stock/newlot' => array(

					// le nom du vaccin
					array(
					    'field' => 'vaccinLOT',
                        'label' => 'Vaccin',
                        'rules' => 'required'
					),

					// le numéro du nouveau lot
					array(
					    'field' => 'newlot',
	                    'label' => 'Nouveau Lot',
	                    'rules' => 'required|alpha_numeric'
					),

					// la quantité
					array(
					    'field' => 'quantity',
	                    'label' => 'Quantité',
	                    'rules' => 'required|numeri|is_natural_no_zero'
					),

				),

				// Formulaire pour ajouter des régularisations dans Stock
				'stock/newregulation' => array(

					// le nom du vaccin
					array(
		    			'field' => 'vaccinREG',
                        'label' => 'Vaccin',
                        'rules' => 'required'
					),

					// le lot du vaccin
					array(
					    'field' => 'lotAjax',
	                    'label' => 'Lot',
	                    'rules' => 'required'
					),

					// la nouvelle quantité
					array(
					    'field' => 'newquantity',
	                    'label' => 'Nouvelle Quantité',
	                    'rules' => 'trim|required|numeric|is_natural_no_zero'
					),

					// commentaires
					array(
					    'field' => 'comment',
	                    'label' => 'Commentaires',
	                    'rules' => 'trim|required'
					),
				),
				
				
				// Formulaire dossier médical
				'medicalrecord/update' => array(
					// Variable cachée indiquant la clé de l'utilisateur
                    array(  
                            'field' => 'customer_key',
                            'label' => 'CUSTOMER_KEY',
                            'rules' => 'trim|required|exact_length[10]'
                        )
				),

				// Formulaire de modification d'un médecin (backend/doctor/view)
				'doctor/update' => array(
					// Civilité
					array(
							'field' => 'title',
							'label' => 'Civilité',
							'rules' => 'trim|required|xss_clean|max_length[5]'
						),
					// Prénom
					array(
							'field' => 'firstname',
							'label' => 'Prénom',
							'rules' => 'trim|required|xss_clean|max_length[30]'
						),
					// Nom
					array(
							'field' => 'lastname',
							'label' => 'Nom',
							'rules' => 'trim|required|xss_clean|max_length[30]'
					    ),
					// Date de naissance
					array(
							'field' => 'birthdate',
							'label' => 'Date de naissance',
							'rules' => 'trim|xss_clean|exact_length[10]'
						),
					// Ville de naissance
                    array(
                            'field' => 'birthcity',
                            'label' => 'Ville de naissance',
                            'rules' => 'trim|xss_clean|max_length[50]'
                        ),
                    // Pays de naissance
                    array(
                            'field' => 'birth_country_id',
                            'label' => 'Pays de naissance',
                            'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
                        ),
                    // Doctor type
                    array(
                    		'field' => 'type',
                    		'label' => 'Fonction',
                    		'rules' => 'trim|xss_clean|required|exact_length[1]|less_than[3]'
                    	)
				),

				// Creation d'un médecin
				'doctor/create' => array(
					// Variable cachée indiquant le POST
                    array(
                            'field' => 'post',
                            'label' => 'POST',
                            'rules' => 'trim|required|greater_than[0]|less_than[2]'
                        ),
					// Civilité
					array(
							'field' => 'title',
							'label' => 'Civilité',
							'rules' => 'trim|required|xss_clean|max_length[5]'
						),
					// Prénom
					array(
							'field' => 'firstname',
							'label' => 'Prénom',
							'rules' => 'trim|required|xss_clean|max_length[30]'
						),
					// Nom
					array(
							'field' => 'lastname',
							'label' => 'Nom',
							'rules' => 'trim|required|xss_clean|max_length[30]'
					    ),
					// Date de naissance
					array(
							'field' => 'birthdate',
							'label' => 'Date de naissance',
							'rules' => 'trim|xss_clean|exact_length[10]'
						),
					// Ville de naissance
                    array(
                            'field' => 'birthcity',
                            'label' => 'Ville de naissance',
                            'rules' => 'trim|xss_clean|max_length[50]'
                        ),
                    // Pays de naissance
                    array(
                            'field' => 'birth_country_id',
                            'label' => 'Pays de naissance',
                            'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
                        ),
                    // Doctor type
                    array(
                    		'field' => 'type',
                    		'label' => 'Fonction',
                    		'rules' => 'trim|xss_clean|required|exact_length[1]|less_than[3]'
                    	),
					// Adresse 1
					array(
							'field' => 'address1',
							'label' => 'Adresse',
							'rules' => 'trim|xss_clean'
					    ),
					// Complément adresse
					array(
							'field' => 'address2',
							'label' => 'Complément adresse',
							'rules' => 'trim|xss_clean'
					    ),
					// Code postal
					array(
							'field' => 'postalcode',
							'label' => 'Code postal',
							'rules' => 'trim|xss_clean|numeric|exact_length[5]'
					    ),
					// Ville
					array(
							'field' => 'city',
							'label' => 'Ville',
							'rules' => 'trim|xss_clean|max_length[50]'
					    ),
					// Pays
					array(
							'field' => 'country_id',
							'label' => 'Pays',
							'rules' => 'trim|xss_clean|greater_than[-1]|less_than[252]'
					    ),
					// Téléphone
					array(
							'field' => 'phone',
							'label' => 'Téléphone',
							'rules' => 'trim|xss_clean|numeric|exact_length[10]'
					    ),
					// Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|xss_clean|valid_email|user_unique_email'
					    ),
					// Confirmation adresse e-mail
					array(
							'field' => 'email_confirm',
							'label' => 'Confirmation adresse e-mail',
							'rules' => 'trim|xss_clean|valid_email|matches[email]'
					    ),
					// User right
                    array(
                    		'field' => 'user_right',
                    		'label' => 'Droits',
                    		'rules' => 'trim|xss_clean|required|exact_length[1]|less_than[4]'
                    	)
				),

				// Demande de nouveau mot de passe
				'newpasswordrequest' => array(					

					// Login / Adresse e-mail
					array(
							'field' => 'email',
							'label' => 'Adresse e-mail',
							'rules' => 'trim|required|xss_clean|valid_email|user_exists[true]|max_length[255]'
				        )
				),

				// Formulaire nouveau mot de passe
				'newpassword' => array(
					// Nouveau mot de passe
					array(
							'field' => 'newpassword',
							'label' => 'Nouveau mot de passe',
							'rules' => 'trim|required|min_length[6]'
					    ),
					// Confirmation nouveau mot de passe
					array(
							'field' => 'newpassword_confirm',
							'label' => 'Confirmation nouveau mot de passe',
							'rules' => 'trim|required|matches[newpassword]'
					    )
				),
					
				// Paramètres
				'parameters/save' => array(
					// isLongTripFrom
					array(
							'field' => 'isLongTripFrom',
							'label' => 'isLongTripFrom',
							'rules' => 'trim|required|numeric'
						),
					// appointmentNbMaxCustomer
					array(
							'field' => 'appointmentNbMaxCustomer',
							'label' => 'appointmentNbMaxCustomer',
							'rules' => 'trim|required|numeric'
						),
					// appointment1Pduration
					array(
							'field' => 'appointment1Pduration',
							'label' => 'appointment1Pduration',
							'rules' => 'trim|required|numeric'
						),
					// appointmentLongTripMinDuration
					array(
							'field' => 'appointmentLongTripMinDuration',
							'label' => 'appointmentLongTripMinDuration',
							'rules' => 'trim|required|numeric'
						),
					// appointmentNPdurationPP
					array(
							'field' => 'appointmentNPdurationPP',
							'label' => 'appointmentNPdurationPP',
							'rules' => 'trim|required|numeric'
						),
					// appointmentEmergencySlotDuration
					array(
							'field' => 'appointmentEmergencySlotDuration',
							'label' => 'appointmentEmergencySlotDuration',
							'rules' => 'trim|required|numeric'
						),
					// appointmentNbRoom
					array(
							'field' => 'appointmentNbRoom',
							'label' => 'appointmentNbRoom',
							'rules' => 'trim|required|numeric'
						),
					// emailContact
					array(
							'field' => 'emailContact',
							'label' => 'emailContact',
							'rules' => 'trim|xss_clean|required|valid_email'
						)
				),

				// Paramètres Documents
				'dparameters/save' => array(

					array(
							'field' => 'hospital_phone_number',
							'label' => 'hospital_phone_number',
							'rules' => 'trim|required'
						),

					array(
							'field' => 'hospital_finess',
							'label' => 'hospital_finess',
							'rules' => 'trim|required'
						),

					array(
							'field' => 'center_phone_number',
							'label' => 'center_phone_number',
							'rules' => 'trim|required'
						),

					array(
							'field' => 'center_fax',
							'label' => 'center_fax',
							'rules' => 'trim|required'
						),

					array(
							'field' => 'head_service',
							'label' => 'head_service',
							'rules' => 'trim|required'
						),	

					array(
							'field' => 'adeli_head_service',
							'label' => 'adeli_head_service',
							'rules' => 'trim|required'
						),	
					
					array(
							'field' => 'doctors',
							'label' => 'doctors',
							'rules' => 'trim|required'
						),					
				),

				
				// Remarques sur rendez-vous
				'appointment/updateFeedback' => array(
					// Champ remarques
					array(
						'field' => 'feedback',
						'label' => 'Remarques',
						'rules' => 'trim|required|xss_clean'
					)
				)
			);
		
?>

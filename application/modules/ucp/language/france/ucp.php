<?php

/**
 * Note to module developers:
 *  Keeping a module specific language file like this
 *  in this external folder is not a good practise for
 *  portability - I do not advice you to do this for
 *  your own modules since they are non-default.
 *  Instead, simply put your language files in
 *  application/modules/yourModule/language/
 *  You do not need to change any code, the system
 *  will automatically look in that folder too.
 */

// UCP
$lang['user_panel'] = "Panneau de contrôle utilisateur";
$lang['account_overview'] = "Aperçu du compte";
$lang['account_characters'] = "Personnages du compte";

$lang['nickname'] = "Pseudo";
$lang['change_nickname'] = "Changer le pseudo";

$lang['username'] = "Nom d'utilisateur";

$lang['location'] = "Lieu";
$lang['change_location'] = "Changer le lieu";

$lang['email'] = "Email";
$lang['change_email'] = "Changer l'email";

$lang['password'] = "Mot de passe";
$lang['change_password'] = "Changer le mot de passe";

$lang['account_rank'] = "Rang du compte";
$lang['voting_points'] = "Points de vote";
$lang['donation_points'] = "Points de don";
$lang['account_status'] = "Statut du compte";
$lang['member_since'] = "Membre depuis";
$lang['data_tip_vote'] = "Gagnez des points de vote en votant pour le serveur";
$lang['data_tip_donate'] = "Gagnez des points de don en faisant un don au serveur";

$lang['edit'] = "Modifier";

// Avatar
$lang['change_avatar'] = "Changer l'avatar";
$lang['avatar_invalid'] = "L'avatar sélectionné est invalide.";
$lang['avatar_invalid_rank'] = "L'avatar sélectionné nécessite un rang utilisateur plus élevé.";

// Settings
$lang['settings'] = "Paramètres du compte";

$lang['old_password'] = "Ancien mot de passe";
$lang['new_password'] = "Nouveau mot de passe";
$lang['new_password_confirm'] = "Confirmer le mot de passe";
$lang['new_password_submit'] = "Changer le mot de passe";

$lang['nickname_error'] = "Le pseudo doit comporter entre 4 et 14 caractères et ne peut contenir que des lettres et des chiffres";
$lang['location_error'] = "Le lieu ne peut contenir que jusqu'à 32 caractères et ne peut contenir que des lettres";
$lang['pw_doesnt_match'] = "Les mots de passe ne correspondent pas !";
$lang['changes_saved'] = "Les modifications ont été enregistrées !";
$lang['invalid_pw'] = "Mot de passe incorrect !";
$lang['nickname_taken'] = "Le pseudo est déjà pris";
$lang['invalid_language'] = "Langue invalide";

$lang['change_information'] = "Modifier les informations";

// Security
$lang['account_security'] = "Sécurité du compte";
$lang['save_changes'] = "Enregistrer les modifications";
$lang['two_factor'] = "AUTHENTIFICATION À DEUX FACTEURS";
$lang['two_factor_description'] = "L'authentification à deux facteurs aide à protéger votre compte contre les accès non autorisés en ajoutant une couche de sécurité supplémentaire.";
$lang['two_factor_help'] = "Téléchargez l'application Google Authenticator depuis Google Play ou l'App Store. Lancez l'application et utilisez l'appareil photo de votre téléphone pour scanner le code-barres ci-dessous. Entrez le code de vérification à 6 chiffres généré par l'application Authenticator.";
$lang['qr_code'] = "Code QR";
$lang['qr_code_help_1'] = "Impossible de scanner le code QR ? Vous pouvez également entrer la";
$lang['qr_code_help_2'] = "clé manuellement.";
$lang['select_authentication'] = "Sélectionner la méthode d'authentification";
$lang['disabled'] = "Désactivé";
$lang['google_authenticator'] = "Google Authenticator";
$lang['six_digit_auth_code'] = "Code Authenticator à 6 chiffres";
$lang['six_digit_not_empty'] = "Le code Authenticator à 6 chiffres ne peut pas être vide";
$lang['six_digit_not_true'] = "Le code Authenticator est incorrect";

// Recent Activity
$lang['recent_activity'] = 'Activité récente';
$lang['account_login'] = 'Connexion au compte';
$lang['account_logout'] = 'Déconnexion du compte';
$lang['account_recovery'] = 'Récupération du compte';
$lang['service'] = 'Service';
$lang['character'] = 'Personnage';
$lang['amount'] = 'Montant';
$lang['ip'] = 'IP';
$lang['today'] = 'Aujourd\'hui';
$lang['yesterday'] = 'Hier';

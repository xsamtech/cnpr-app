<?php
/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Notifications Language Lines
    |--------------------------------------------------------------------------
    |
    */

    // ===== ERROR PAGES
    // 400
    '400_title' => 'Mauvaise requête',
    '400_description' => 'Vérifiez votre requête s\'il vous plait !',
    // 401
    '401_title' => 'Non autorisé',
    '401_description' => 'Vous n\'avez pas d\'autorisation pour cette requête.',
    // 403
    '403_title' => 'Espace interdit',
    '403_description' => 'Cet espace n\'est pas permis.',
    // 404
    '404_title' => 'Page non trouvée',
    '404_description' => 'La page que vous cherchez n\'existe pas',
    // 405
    '405_title' => 'Méthode non permise',
    '405_description' => 'Votre requête est envoyée avec une mauvaise méthode.',
    // 419
    '419_title' => 'Page expirée',
    '419_description' => 'La page a mis longtemps sans activité.',
    // 500
    '500_title' => 'Erreur interne',
    '500_description' => 'Notre serveur rencontre un problème. Veuillez réessayez après quelques minutes s\'il vous plait !',
    // Others
    'expects_json' => 'La requête actuelle attend probablement une réponse JSON.',

    // ===== ALERTS
    'no_record' => 'Il n\'y a aucun enregistrement !',
    'create_error' => 'La création a échoué !',
    'update_error' => 'La modification a échoué !',
    'registered_data' => 'Données enregistrées',
    'updated_data' => 'Données modifiées',
    'deleted_data' => 'Données supprimées',
    'required_fields' => 'Veuillez vérifier les champs obligatoires',
    'transaction_waiting' => 'Veuillez valider le message de votre opérateur sur votre téléphone. Ensuite appuyez sur le bouton ci-dessous.',
    'transaction_done' => 'Votre opération est terminée !',
    'transaction_failed' => 'L\'envoi de votre paiement a échoué',
    'transaction_type_error' => 'Veuillez choisir le type de transaction',
    'new_partner_message' => 'Vous pouvez maintenant vous connecter en tant que partenaire avec votre n° de téléphone. Mot de passe temportaire :',
    // Province
    'find_all_provinces_success' => 'Provinces trouvées',
    'find_province_success' => 'Province trouvée',
    'find_province_404' => 'Province non trouvée',
    'create_province_success' => 'Province créée',
    'update_province_success' => 'Province modifiée',
    'delete_province_success' => 'Province supprimée',
    // City
    'find_all_cities_success' => 'Provinces trouvées',
    'find_city_success' => 'Province trouvée',
    'find_city_404' => 'Province non trouvée',
    'create_city_success' => 'Province créée',
    'update_city_success' => 'Province modifiée',
    'delete_city_success' => 'Province supprimée',
    // Group
    'find_all_groups_success' => 'Groupes trouvés',
    'find_group_success' => 'Groupe trouvé',
    'find_group_404' => 'Groupe non trouvé',
    'create_group_success' => 'Groupe créé',
    'update_group_success' => 'Groupe modifié',
    'delete_group_success' => 'Groupe supprimé',
    // Status
    'find_all_statuses_success' => 'Etats trouvés',
    'find_status_success' => 'Etat trouvé',
    'find_status_404' => 'Etat non trouvé',
    'create_status_success' => 'Etat créé',
    'update_status_success' => 'Etat modifié',
    'delete_status_success' => 'Etat supprimé',
    // Type
    'find_all_types_success' => 'Types trouvés',
    'find_type_success' => 'Type trouvé',
    'find_type_404' => 'Type non trouvé',
    'create_type_success' => 'Type créé',
    'update_type_success' => 'Type modifié',
    'delete_type_success' => 'Type supprimé',
    // File
    'find_all_files_success' => 'Fichiers trouvés',
    'find_file_success' => 'Fichier trouvé',
    'find_file_404' => 'Fichier non trouvé',
    'create_file_success' => 'Fichier créé',
    'update_file_success' => 'Fichier modifié',
    'delete_file_success' => 'Fichier supprimé',
    // Role
    'find_all_roles_success' => 'Rôles trouvés',
    'find_role_success' => 'Rôle trouvé',
    'find_role_404' => 'Rôle non trouvé',
    'create_role_success' => 'Rôle créé',
    'update_role_success' => 'Rôle modifié',
    'delete_role_success' => 'Rôle supprimé',
    // User
    'find_all_users_success' => 'Utilisateurs trouvés',
    'find_user_success' => 'Utilisateur trouvé',
    'find_api_token_success' => 'Jeton d\'API trouvé',
    'find_user_404' => 'Utilisateur non trouvé',
    'create_user_success' => 'Utilisateur créé',
    'create_user_SMS_failed' => 'Il y a un problème avec le service des SMS',
    'update_user_success' => 'Utilisateur modifié',
    'update_password_success' => 'Mot de passe modifié',
    'confirm_password_error' => 'Veuillez confirmer votre mot de passe',
    'confirm_new_password' => 'Veuillez confirmer le nouveau mot de passe',
    'delete_user_success' => 'Utilisateur supprimé',
    // PasswordReset
    'find_all_password_resets_success' => 'Réinitialisations des mots de passe trouvées',
    'find_password_reset_success' => 'Réinitialisation de mot de passe trouvée',
    'find_password_reset_404' => 'Réinitialisation de mot de passe non trouvée',
    'create_password_reset_success' => 'Réinitialisation de mot de passe créée',
    'update_password_reset_success' => 'Réinitialisation de mot de passe modifiée',
    'delete_password_reset_success' => 'Réinitialisation de mot de passe supprimée',
    // Session
    'find_all_sessions_success' => 'Sessions trouvées',
    'find_session_success' => 'Session trouvée',
    'find_session_404' => 'Session non trouvée',
    'create_session_success' => 'Session créée',
    'update_session_success' => 'Session modifiée',
    'delete_session_success' => 'Session supprimée',
    // Department
    'find_all_departments_success' => 'Départements trouvés',
    'find_department_success' => 'Département trouvé',
    'find_department_404' => 'Département non trouvé',
    'create_department_success' => 'Département créé',
    'update_department_success' => 'Département modifié',
    'delete_department_success' => 'Département supprimé',
    // Branch
    'find_all_branches_success' => 'Antennes trouvés',
    'find_branch_success' => 'Antenne trouvé',
    'find_branch_404' => 'Antenne non trouvé',
    'create_branch_success' => 'Antenne créé',
    'update_branch_success' => 'Antenne modifié',
    'delete_branch_success' => 'Antenne supprimé',
    // PresenseAbsence
    'find_all_presence_absences_success' => 'Présenses / Absences trouvées',
    'find_presence_absence_success' => 'Présense / Absence trouvée',
    'find_presence_absence_404' => 'Présense / Absence non trouvée',
    'create_presence_absence_success' => 'Présense / Absence créée',
    'update_presence_absence_success' => 'Présense / Absence modifiée',
    'delete_presence_absence_success' => 'Présense / Absence supprimée',
    // Message
    'find_all_messages_success' => 'Messages trouvés',
    'find_message_success' => 'Message trouvé',
    'find_message_404' => 'Message non trouvé',
    'create_message_success' => 'Message créé',
    'update_message_success' => 'Message modifié',
    'delete_message_success' => 'Message supprimé',
    // Notification
    'find_all_notifications_success' => 'Notifications trouvées',
    'find_notification_success' => 'Notification trouvée',
    'find_notification_404' => 'Notification non trouvée',
    'create_notification_success' => 'Notification créée',
    'update_notification_success' => 'Notification modifiée',
    'delete_notification_success' => 'Notification supprimée',
    // History
    'find_all_histories_success' => 'Historiques trouvées',
    'find_history_success' => 'Historique trouvée',
    'find_history_404' => 'Historique non trouvée',
    'create_history_success' => 'Historique créée',
    'update_history_success' => 'Historique modifiée',
    'delete_history_success' => 'Historique supprimée',
    // Task
    'find_all_tasks_success' => 'Tâches trouvées',
    'find_task_success' => 'Tâche trouvée',
    'find_task_404' => 'Tâche non trouvée',
    'create_task_success' => 'Tâche créée',
    'update_task_success' => 'Tâche modifiée',
    'delete_task_success' => 'Tâche supprimée',
    // PaidUnpaid
    'find_all_paid_unpaids_success' => 'Rémunérations trouvées',
    'find_paid_unpaid_success' => 'Rémunération trouvée',
    'find_paid_unpaid_404' => 'Rémunération non trouvée',
    'create_paid_unpaid_success' => 'Rémunération créée',
    'update_paid_unpaid_success' => 'Rémunération modifiée',
    'delete_paid_unpaid_success' => 'Rémunération supprimée',
    // Vacation
    'find_all_vacations_success' => 'Congés trouvés',
    'find_vacation_success' => 'Congé trouvé',
    'find_vacation_404' => 'Congé non trouvé',
    'create_vacation_success' => 'Congé créé',
    'update_vacation_success' => 'Congé modifié',
    'delete_vacation_success' => 'Congé supprimé',

    // ===== APP HISTORY / NOTIFICATIONS
    'welcome_manager' => 'Bienvenue cher manager. Dans cet espace, vous êtes en mesure de gérer les employés de votre antenne.',
    'welcome_employee' => 'Bienvenue sur CNPR-APP. Ici, vous pourrez gérer vos présences au boulot et votre temps de travail quotidien.',
    'employee_locked' => 'Votre compte est bloqué. Si vous avez des questions, contactez le manager ou la direction centrale.',
    'you_updated_account' => 'Vous avez modifié vos informations personnelles.',
    'you_changed_avatar' => 'Vous avez modifié votre avatar.',
    'you_changed_password' => 'Vous avez changé votre mot de passe.',
    'you_changed_password_of' => 'Vous avez changé le mot de passe de ',
    'you_activate_account' => 'Vous avez réactivé votre compte.',
    'you_deactivate_account' => 'Vous avez désactivé votre compte.',
    'is_added_masculine' => ' est ajouté.',
    'is_added_feminine' => ' est ajoutée.',
    'is_changed_masculine' => ' est modifié.',
    'is_changed_feminine' => ' est modifiée.',
    'is_withdrawn_masculine' => ' est retiré.',
    'is_withdrawn_feminine' => ' est retirée.',
    'is_withdrawn_from_you_masculine' => ' vous est retiré.',
    'is_withdrawn_from_you_feminine' => ' vous est retirée.',
    'changed' => ' a modifié ',
    'changed_answer' => ' a modifié sa réponse.',
    'admin_changed' => 'L\'administrateur a modifié ',
    'manager_changed' => 'Le manager a modifié ',
    'admin_changed_message' => 'L\'administrateur a modifié son message.',
    'manager_changed_message' => 'Le manager a modifié son message.',
    'admin_changed_answer' => 'L\'administrateur a modifié sa réponse.',
    'manager_changed_answer' => 'Le manager a modifié sa réponse.',
    'manager_published' => 'Le manager a publié',
    'admin_changed_status' => 'L\'administrateur a modifié votre état.',
    'manager_changed_status' => 'Le manager a modifié votre état.',
    'you_changed_status' => 'Vous avez modifié l\'état de ',
    'admin_changed_role' => 'L\'administrateur a modifié votre rôle.',
    'manager_changed_role' => 'Le manager a modifié votre rôle.',
    'you_choose_department_chief' => 'Vous avez désigné :chief_names comme chef de département',
    'you_are_now_chief' => 'Vous êtes maintenant chef de département',
    'you_are_no_longer_chief' => 'Vous n\'êtes plus chef de département',
    'you_sent' => 'Vous avez envoyé ',
    'sent' => ' a envoyé ',
    'admin_sent' => 'L\'administrateur a envoyé ',
    'manager_sent' => 'Le manager a envoyé ',
    'sent_message' => ' vous a envoyé un message.',
    'admin_sent_message' => 'L\'administrateur vous a envoyé un message.',
    'manager_sent_message' => 'Le manager vous a envoyé un message.',
    'you_answered_masculine' => 'Vous avez répondu à un ',
    'you_answered_feminine' => 'Vous avez répondu à une ',
    'answered_masculine' => ' a répondu à un ',
    'answered_feminine' => ' a répondu à une ',
    'admin_answered_masculine' => 'L\'administrateur a répondu à un ',
    'admin_answered_feminine' => 'L\'administrateur a répondu à une ',
    'manager_answered_masculine' => 'Le manager a répondu à un ',
    'manager_answered_feminine' => 'Le manager a répondu à une ',
    'answered_message' => ' a répondu à un message.',
    'you_changed_role' => 'Vous avez modifié le rôle de ',
    'you_placed_nth_to_branch' => 'Vous avez placé :nth :person à l\'antenne ',
    'nth_one_person' => 'personne',
    'nth_much_person' => 'personnes',
    'you_placed_to_branch' => 'Vous avez placé :employee_names à l\'antenne ',
    'you_placed_to_department' => 'Vous avez placé :employee_names au département ',
    'you_are_placed_branch' => 'Vous êtes :placed à l\'antenne ',
    'you_are_placed_department' => 'Vous êtes :placed au département ',
    'placed_masculine' => 'placé',
    'placed_feminine' => 'placée',
    'you_removed_to_branch' => 'Vous avez retiré :employee_names de l\'antenne ',
    'you_removed_to_department' => 'Vous avez retiré :employee_names du département ',
    'you_are_removed_branch' => 'Vous êtes :removed de l\'antenne ',
    'you_are_removed_department' => 'Vous êtes :removed du département ',
    'removed_masculine' => 'retiré',
    'removed_feminine' => 'retirée',
    'you_received_task' => 'Vous avez reçu une tâche.',
    'your_task_changed' => 'Votre tâche a été modifiée.',
    'departement_received_task' => 'Votre département a reçu une tâche.',
    'department_task_changed' => 'La tâche de votre département a été modifiée.',
    'task_named' => 'La tâche appelée ',
];

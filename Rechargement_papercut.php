<?php

$conf = require __DIR__ . '/conf.php';

// Initialisation des connexions aux bases de données
$confSQL = $conf['papercut_reloads_payicam_mysql'];
$DB_payicam = new \Payutc\DB($confSQL['sql_host'], $confSQL['sql_user'], $confSQL['sql_pass'], $confSQL['sql_db']);
$confSQL = $conf['papercut_mysql'];
$DB_papercut = new \Payutc\DB($confSQL['sql_host'], $confSQL['sql_user'], $confSQL['sql_pass'], $confSQL['sql_db']);

// On récupère les rechargement qui doivent être pris en compte dans papercut
// id, tra_id, user_mail, amount, tra_date, fetched_by_papercut
$newReloads = $DB_payicam->query('SELECT * FROM reloads WHERE fetched_by_papercut = 0');

$payicamReloadsIdOk = [];
foreach ($newReloads as $key => $reload) {
    // On récupére le solde actuel papercut
    $old_balance = current($DB_papercut->queryFirst('SELECT balance FROM tbl_account WHERE account_name = :user_mail', ['user_mail' => $reload['user_mail']]));

    // On ajoute au solde actuel le rechargement
    $new_balance = $old_balance + $reload['amount'];
    $DB_papercut->query('UPDATE tbl_account SET balance = :balance WHERE account_name = :user_mail', ['user_mail' => $reload['user_mail'], 'balance' => $new_balance]);

    // On dit à payicam que ce rechargement a bien été pris en compte
    $payicamReloadsIdOk[] = $reload['id'];
}

if (!empty($payicamReloadsIdOk)) {
    // On envoie d'une shot les reloads qu'on a pris en compte à payicam pour pas créer 15 000 requêtes SQL
    $newReloads = $DB_payicam->query('UPDATE reloads SET fetched_by_papercut = 1 WHERE id IN ('.implode(', ', $payicamReloadsIdOk).')');
}

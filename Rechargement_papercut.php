<?php
//echo "tu es sur la bonne page pour le rechargement de la BDD papercut ! #VICTOIRE";
?>

<br />

<?php
try
{

    $bdd_payicam = new PDO('mysql:host=xxxxx;dbname=xxxx;charset=utf8', 'xxxx', 'xxxxx');
}
catch(Exception $e)
{

        die('Erreur : '.$e->getMessage());
}

$bdd_payicam -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try
{

    $bdd_local = new PDO('mysql:host=xxxx;dbname=xxxx;charset=utf8', 'xxx', 'xxx');
}
catch(Exception $e)
{

        die('Erreur : '.$e->getMessage());
}

$bdd_local -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reponse = $bdd_payicam->query('SELECT * FROM rechargement WHERE tra_status = 0');


foreach ($reponse as $key => $value) 

{
   // echo($value['amount']);
    //var_dump($value['amount']);

    $old_amount = $bdd_local->query('SELECT balance FROM tbl_account WHERE account_name ="'.$value['user_mail'].'"');

    $donnees = $old_amount->fetch(PDO::FETCH_COLUMN);
   // echo($donnees);

    //var_dump($donnees);

    $new_amount = $donnees + $value['amount'];

   // var_dump($new_amount);

    $recharge = $bdd_local->query ('UPDATE tbl_account SET balance="'.$new_amount.'" WHERE account_name ="'.$value['user_mail'].'"');

     $amount_to_check = $bdd_local->query('SELECT balance FROM tbl_account WHERE account_name ="'.$value['user_mail'].'"');
     $data_to_check = $amount_to_check->fetch(PDO::FETCH_COLUMN);

    	if ($data_to_check ==  $new_amount)
    	{
    	$recharge2 = $bdd_payicam->query('UPDATE rechargement SET tra_status = 1 WHERE user_mail ="'.$value['user_mail'].'"');
            var_dump($recharge2);

    	}
        else
            { echo('ca n a pas marche');
    }
  //  echo ("L'utilisateur ".$value['user_mail']." à un nouveau solde de".$new_amount.);

}


?>
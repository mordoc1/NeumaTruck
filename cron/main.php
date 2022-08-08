<?php
$mysql_hostname = "localhost";
$mysql_user = "neum45356_neumatruck";
$mysql_password = "7340458Tao";
$mysql_database = "neum45356_neumatruck";

// $base = new PDO('mysql:host='.$mysql_hostname.'; dbname='.$mysql_database, $mysql_user, $mysql_password);
// $base->exec("SET CHARACTER SET utf8");



// $sql2 = "INSERT INTO demo_crono (data_crono) VALUE('pipo')";
// $stmt= $base->prepare($sql2);
// $stmt->execute();
// $stmt->closeCursor();


$server = '{mail.neumatruck.cl:993/imap/ssl/novalidate-cert}INBOX';     
$usr = 'contacto@neumatruck.cl';
$pwd = '7340458Tao';
$inbox = array();

$connection = imap_open($server, $user, $pwd);

$num_msg = imap_num_msg($connection);

$limit = 3;

for($i = 1; $i <= $num_msg; $i++) {
    echo "hola mundo";
    // $inbox[] = array(
    //   'index'     => $i,
    //   'header'    => imap_headerinfo($connection, $i),
    //   'body'      => imap_body($connection, $i),
    //   'structure' => imap_fetchstructure($connection, $i)
    // );

    if($i == $limit){
        break;
    }
    
}


?>
<?php
include "conn/pdo.php";

$rml = addslashes($_GET['rml']);
$dsc = addslashes($_GET['dsc']);
$typ = addslashes($_GET['typ']);

try {
    if ( $rml && $dsc && $typ ) {
        $g = $conn->query("UPDATE ramais SET dsc='$dsc', tipo='$typ' WHERE ramal='$rml'");
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
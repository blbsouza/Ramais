<?php
include "conn/pdo.php";

$rml = addslashes($_GET['rml']);

try {
    if ( $rml ) {
        $g = $conn->query("DELETE FROM ramais WHERE ramal='$rml'");
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
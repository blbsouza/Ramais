<?php
include "conn/pdo.php";

$rml = addslashes($_GET['rml']);
$dsc = addslashes($_GET['dsc']);
$typ = addslashes($_GET['typ']);

try {
if ( $rml && $dsc && $typ ) {
    $b = $conn->query("SELECT * FROM ramais WHERE ramal='$rml'");
    $n = $b->rowCount();

    if ($n > 0) {
        echo json_encode(['typ' => 0]);
    } else {
        $g = $conn->query("INSERT INTO ramais(ramal, dsc, tipo)VALUES($rml, '$dsc', $typ)");
        echo json_encode(['typ' => 1]);
    }
}
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
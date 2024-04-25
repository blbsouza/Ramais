<?php
include "conn/pdo.php";


try {
$col = !$_GET['col'] ? 'ramal' : $_GET['col'];
$ord = !$_GET['ord'] ? 'dsc' : $_GET['ord'];
$s = addslashes($_GET['s']);

if (!$s) {
    $b = $conn->query("SELECT * FROM ramais ORDER BY $col $order");
} else {
    $t = $conn->query("SELECT * FROM ramais WHERE ramal='$s' OR dsc='$s' ORDER BY $col $order");
    $n = $t->rowCount();
    if ($n > 0) {
        $b = $t;
    } else {
        $t = $conn->query("SELECT * FROM ramais WHERE ramal LIKE '%$s' OR ramal LIKE '$s%' OR ramal LIKE '%$s%' OR dsc LIKE '%$s' OR dsc LIKE '$s%' OR dsc LIKE '%$s%'");
        $n = $t->rowCount();
        if ($n > 0) {
            $b = $t;
        } else {
            return false;
        }
    }
}

    if ($b) {
        $array = [];

        $i = 0;
        $t = $b->fetchAll();
        
        foreach ( $t as $row ) {
            $array[$i]['rml'] = $row['ramal'];
            $array[$i]['dsc'] = $row['dsc'];
            $array[$i]['tipo'] = intval($row['tipo']);
            $i++;
        }

        echo json_encode($array);
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
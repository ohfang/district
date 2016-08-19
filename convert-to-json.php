<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=test', 'root', '');

    $parentDistrict = [];
    foreach($dbh->query('SELECT * FROM district ORDER BY `order`') as $row) {
        if (!isset($parentDistrict[$row['parentid']])) {
            $parentDistrict[$row['parentid']] = [];
        }
        $parentDistrict[$row['parentid']][] = [
            'id'   => $row['id'],
            'name' => $row['name'],
        ];
    }
    foreach ($parentDistrict as $pid => &$children) {
        $children = json_encode($children);
    }
    echo json_encode($parentDistrict);

    $dbh = null;

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

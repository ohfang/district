<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=test', 'root', '');

    $parentDistrict = [];
    foreach($dbh->query('SELECT * FROM district WHERE id IS NOT NULL ORDER BY `order`') as $row) {
        if (!isset($parentDistrict[$row['parentid']])) {
            $parentDistrict[$row['parentid']] = [];
        }
        $parentDistrict[$row['parentid']][] = [
            'id'   => $row['id'],
            'name' => $row['name'],
        ];
    }

    $jsStr = '{';
    foreach ($parentDistrict as $pid => $children) {
        $jsStr .= "{$pid}:[";
        if (!empty($children)) {
            foreach ($children as $child) {
                $jsStr .= "{id:{$child['id']},name:'{$child['name']}'},";
            }
            $jsStr = substr($jsStr, 0, -1);
        }
        $jsStr .= '],';
    }
    $jsStr = substr($jsStr, 0, -1).'}';
    echo $jsStr;

    $dbh = null;

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

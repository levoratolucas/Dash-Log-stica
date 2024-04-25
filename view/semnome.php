<?php
include "../controler/biblioteca.php";
include '../config/config.php';
$sql_spree =
    "SELECT  o.number,u.name,spa.id,o.tiny_id,u.document_value,u.contact_phone,u.email
      FROM spree_orders o 
      join spree_addresses spa on spa.id = o.ship_address_id
      join spree_stores s on s.id = o.store_id
      JOIN spree_users u ON u.id = o.user_id
      JOIN employee_shopkeeper_stores e ON e.spree_user_id = u.id
      WHERE spa.firstname ='' and o.state = 'complete' and to_char(completed_at,'YY')>'23';";
$data = executeQuery($db_pg, $sql_spree);
renderTable($data, 'table');
?>
<?php

require_once "../includes/bootstrap.php";
requireRole('technician');

$page = $_GET['page'] ?? 'home';

$page_content = __DIR__ . "/content/$page.php";

include "../shared/layout.php";
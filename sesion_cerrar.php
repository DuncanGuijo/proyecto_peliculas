<?php

include("admin/sesion.php");
session_destroy();
header("location:index.php");

?>

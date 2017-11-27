<?php

require 'sqlConfig.php';

$db = mysqli_connect(DB_HOST, DB_USERNAME, '',DB_NAME)
    or die('Trouble with connection database: ' . mysqli_connect_error());
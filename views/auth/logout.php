<?php

session_start();
session_destroy();

header('location: '. $router->url('login'));
exit();
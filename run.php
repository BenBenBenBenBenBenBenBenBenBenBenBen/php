<?php

include "controller.php";

$theController=new Controller;

$theElection=$theController->setup();

echo $theElection->__toString();
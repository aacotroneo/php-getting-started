<?php


$env = getenv('DATABASE_URL');
if ($env !== false) {
    $db_path = $env;
}else {
    //copy env format so as to treat them the same way
    //postgres://gqktpmtgnlwdap:DPrermY_qaD64Jyhto3G9xCXTi@ec2-50-17-233-228.compute-1.amazonaws.com:5432/d45ie6nq6dlc4d

    $db_path = "postgres://postgres:postgres@localhost:5432/deviget";
}

$dbopts = parse_url($db_path);

return array(
    'db' => $dbopts
);
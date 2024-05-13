<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

use Manzano\CvdwCli\Services\Console\CvdwSymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

function conectarDB(InputInterface $input, OutputInterface $output, $showException = true) : \Doctrine\DBAL\Connection
{
    $io = new CvdwSymfonyStyle($input, $output);
    $config = new Configuration();
    $connectionParams = array(
        'dbname' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'driver' => $_ENV['DB_CONNECTION'],
    );

    $conn = DriverManager::getConnection($connectionParams, $config);

    //if(isset($_ENV['DB_HOST'])){
    //    return $conn;
    //}
    
    if (!$conn->isConnected()) {
        try {
            $conn->connect();
        } catch (\Exception $e) {
            if($showException){
                $io->error('Não foi possível conectar ao banco de dados.');
                $io->error('Encontrei esse erro: ' . $e->getMessage());
            }
        }
    } 
    return $conn;
}

<?php
namespace Aac;

use Herrera\Pdo\PdoServiceProvider;
use PDO;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;

class App {


    function __construct($config)
    {
        $app = new Application();
        $app['debug'] = true;

// Register the monolog logging service
        $app->register(new MonologServiceProvider(), array(
            'monolog.logfile' => 'php://stderr',
        ));

        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/Views',
        ));

// Our web handlers

        $app->get('/', function() use($app) {
            $app['monolog']->addDebug('logging output.');
            return 'Hello';
        });

        $app->get('/twig/{name}', function ($name) use ($app) {
            return $app['twig']->render('index.twig', array(
                'name' => $name,
            ));
        });
        $app->get('/db/', function() use($app) {

            $st = $app['pdo']->prepare('SELECT name FROM test_table');
            $st->execute();

            $names = array();
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                $app['monolog']->addDebug('Row ' . $row['name']);
                $names[] = $row;
            }

            return $app['twig']->render('db.twig', array(
                'names' => $names
            ));
        });


        $dbopts = $config['db'];
        $app->register(new PdoServiceProvider(),
            array(
                'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"],
                'pdo.port' => $dbopts["port"],
                'pdo.username' => $dbopts["user"],
                'pdo.password' => $dbopts["pass"]
            )
        );
        $app->run();
    }




} 
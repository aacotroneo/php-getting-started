<?php
namespace Aac;

use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;

class App {


    function __construct()
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

        $app->run();
    }




} 
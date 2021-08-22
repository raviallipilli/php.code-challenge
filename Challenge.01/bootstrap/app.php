<?php

use App\Console\Kernel;
use NunoMaduro\Collision\Provider as Collision;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| Enable Collision
|--------------------------------------------------------------------------
|
| Firstly we load Collision which is a beautiful error reporting when 
| interacting with your app through the command line.
|
*/

(new Collision)->register();

/*
|--------------------------------------------------------------------------
| Load Environment Variables
|--------------------------------------------------------------------------
|
| Secondly we need our environment variables for our console application, by 
| loading our DotEnv file.
|
*/

(new Dotenv())->loadEnv(getcwd() . DIRECTORY_SEPARATOR . '.env');

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Next, we need to create a new Symfony Console Application instance,
| which will be our system container.
|
*/

$app = new Application('Simplestream PHP Code Challenge 01');

/*
|--------------------------------------------------------------------------
| Bind Console Kernel
|--------------------------------------------------------------------------
|
| Finally, we need to load our Console Kernel to provide us with a list of
| console commands.
|
*/

(new Kernel($app))->handle();

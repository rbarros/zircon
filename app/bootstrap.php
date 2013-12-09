<?php
/**
 * This file is part of the Zircon CMS (http://nocriz.com)
 *
 * Copyright (c) 2013  Zircon CMS (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

/**
 * Zircon CMS
 *
 * @package  CMS
 * @author   Ramon Barros <contato@ramon-barros.com>
 */

ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT );
date_default_timezone_set('America/Sao_Paulo');

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__.DS.'..'));
$time = time();
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).'GMT');
/*
| ------------------------------------------------- -------------------------
| Check Extensions
| ------------------------------------------------- -------------------------
|
| The application requires some extensions to work
| And we will see if they are loaded.
|
*/

if ( ! extension_loaded('mcrypt'))
{
    die('Lemee requires the Mcrypt PHP extension.'.PHP_EOL);
    exit(1);
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| This application is installed by the Composer, 
| that provides a class loader automatically.
| Use it to seamlessly and feel free to relax.
|
*/

$composer_autoload = APP_ROOT.DS.'vendor'.DS.'autoload.php';
if(!file_exists($composer_autoload)){
    die('Please use the composer to install http://getcomposer.org');
}
require $composer_autoload;

/**
 * Carrega classe utilizadas no Restler
 */
Illuminate\Support\ClassLoader::addDirectories(array(
     APP_ROOT.DS.'app'.DS.'controllers'
    ,APP_ROOT.DS.'app'.DS.'models'
));

/**
 * Registra o auto carregamento das classes
 */
Illuminate\Support\ClassLoader::register();

/**
 * Instancia da aplicação
 * @var Lemee
 */
$app = new Zircon\Application\App();

$app->detectEnvironment(array(
  'local' => array('http://localhost*', '*.dev')
));

use Luracast\Restler\Restler;
use Luracast\Restler\Defaults;
use Luracast\Restler\Resources;
/**
* Cria uma instância do Restler (true = produção cria na pasta public/cache/ as rotas)
* @var Restler
*/
$restler = new Restler(true);
$app->instance('restful', $restler);

/**
* Desabilita as rotas automáticas
* @var boolean
*/
Defaults::$smartAutoRouting = false;

/**
* API baseada em versão
* /v1
* @var boolean
*/
Defaults::$useUrlBasedVersioning = true;

/**
 * Executa configurações do restler.
 */
$app->run();
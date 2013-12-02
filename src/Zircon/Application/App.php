<?php
/**
 * This file is part of the Zircon CMS (http://nocriz.com)
 *
 * Copyright (c) 2013  Zircon CMS (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace Zircon\Application;

use Closure;

use Zircon\Application\AliasLoader;
use Zircon\Config\FileLoader;
use Zircon\Application\ProviderRepository;

use Luracast\Restler\Restler;
use Luracast\Restler\Defaults;
use Luracast\Restler\Resources;

use Illuminate\Http\Request;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Exception\ExceptionServiceProvider;
use Illuminate\Support\Contracts\ResponsePreparerInterface;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Classe Application
 * Responsavel pelo carregamento das configurações.
 * 
 * @author Ramon Barros <contato@ramon-barros.com>
 *
 */
class App extends Container {

  /**
   * A versão da API.
   *
   * @var string
   */
  const VERSION = 1;

  /**
   * Nome da aplicação
   */
  const APPNAME = 'Zircon API';

  /**
   * Versão da API
   */
  const APPVERSION = 'v1.0.0';

  /**
   * Ambiente da API
   * development|production
   * @var string
   */
  protected $env = 'development';

  /**
   * Instância da aplicação
   * Cria instancias das classes utilizadas na aplicação
   *
   * @var array
   */
  protected $instances = array();

  /**
   * Todos os "serviços" cadastrados.
   *
   * @var array
   */
  protected $serviceProviders = array();

  /**
   * Os nomes dos "serviços" carregados.
   *
   * @var array
   */
  protected $loadedProviders = array();

  /**
   * Os serviços deferidos e os provedores.
   *
   * @var array
   */
  protected $deferredServices = array();

  /**
   * Construtor da aplicação
   */
  public function __construct() {

    /**
     * Cria uma instancia da própria aplicação
     * podendo ser acessado por "app" fora deste recipiente.
     */
    $this->instance('app',$this);

    /**
     * Limpa as instancias da aplicação
     */
    Facade::clearResolvedInstances();

    /**
     * Armazena instancia da aplicação
     */
    Facade::setFacadeApplication($this);

    /**
     * Cria uma instância do Restler
     * @var Restler
     */
    /*
    $restler = new Restler();
    $this->instance('restler', $restler);
    */

    /**
     * Cria uma instância de Repository "Config" utilizado no
     * carregamento dos arquivos da pasta app/config
     * @var Repository
     */
    $config = new Repository($this->getConfigLoader(), $this->env);
    $this->instance('config', $config);
    
    /**
     * Cria uma instância das requisições
     */
    $this->instance('request', $this->createRequest());

    /**
     * Cria uma instância das pastas do arquivo app/config/path.yml
     */
    $this->bindInstallPaths($this['config']->get('path'));

    /**
     * Registra os provedores de serviços das classes Exception e Event
     * para não ser necessário/subtituido no arquivo app/config/app.yml
     */
    //$this->register(new ExceptionServiceProvider($this));

    //$this->register(new RoutingServiceProvider($this));

    //$this->register(new EventServiceProvider($this));

    $this->detectEnvironment(array(
      'local' => array('your-machine-name'),
    ));
    
    /**
     * Efetua o carregamento dos provedores de serviços "Facade"
     */
    //$this->providersBoot();

    /**
     * Efetua o carregamento das aliases
     */
    //$this->aliasLoader();
  }

  /**
   * Recupera a instancia da classe de configuração.
   *
   * @return \Illuminate\Config\LoaderInterface
   */
  public function getConfigLoader()
  {
    return new FileLoader(new Filesystem, APP_ROOT.DS.'app'.DS.'config');
  }

  /**
   * Cria a requisição para a aplicação.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Request
   */
  protected function createRequest(Request $request = null)
  {
    return $request ?: Request::createFromGlobals();
  }

  /**
   * Faz a vinculação dos caminhos para a aplicação.
   * app/config/path.yml
   *
   * @param  array  $paths
   * @return void
   */
  public function bindInstallPaths(array $paths)
  {
    $this->instance('path', realpath($paths['app']));

    foreach (array_except($paths, array('app')) as $key => $value)
    {
      var_dump($key);
      var_dump(realpath($value));
      $this->instance("path.{$key}", realpath($value));
    }
  }

  /**
   * Register a service provider with the application.
   *
   * @param  \Illuminate\Support\ServiceProvider|string  $provider
   * @param  array  $options
   * @return void
   */
  public function register($provider, $options = array())
  {
    // If the given "provider" is a string, we will resolve it, passing in the
    // application instance automatically for the developer. This is simply
    // a more convenient way of specifying your service provider classes.
    if (is_string($provider))
    {
      $provider = $this->resolveProviderClass($provider);
    }
    
    $provider->register();

    // Once we have registered the service we will iterate through the options
    // and set each of them on the application so they will be available on
    // the actual loading of the service objects and for developer usage.
    foreach ($options as $key => $value)
    {
      $this[$key] = $value;
    }

    $this->serviceProviders[] = $provider;

    $this->loadedProviders[get_class($provider)] = true;
  }

  /**
   * Resolve a service provider instance from the class name.
   *
   * @param  string  $provider
   * @return \Illuminate\Support\ServiceProvider
   */
  protected function resolveProviderClass($provider)
  {
    return new $provider($this);
  }

  /**
   * Detect the application's current environment.
   *
   * @param  array|string  $environments
   * @return string
   */
  public function detectEnvironment($environments)
  {
    $base = $this['request']->getHost();

    $arguments = $this['request']->server->get('argv');

    if ($this->runningInConsole())
    {
      return $this->detectConsoleEnvironment($base, $environments, $arguments);
    }

    return $this->detectWebEnvironment($base, $environments);
  }

  /**
   * Determine if we are running in the console.
   *
   * @return bool
   */
  public function runningInConsole()
  {
    return php_sapi_name() == 'cli';
  }

  /**
   * Set the application environment from command-line arguments.
   *
   * @param  string  $base
   * @param  mixed   $environments
   * @param  array   $arguments
   * @return string
   */
  protected function detectConsoleEnvironment($base, $environments, $arguments)
  {
    foreach ($arguments as $key => $value)
    {
      // For the console environment, we'll just look for an argument that starts
      // with "--env" then assume that it is setting the environment for every
      // operation being performed, and we'll use that environment's config.
      if (starts_with($value, '--env='))
      {
        $segments = array_slice(explode('=', $value), 1);

        return $this['env'] = head($segments);
      }
    }

    return $this->detectWebEnvironment($base, $environments);
  }

  /**
   * Set the application environment for a web request.
   *
   * @param  string  $base
   * @param  array|string  $environments
   * @return string
   */
  protected function detectWebEnvironment($base, $environments)
  {
    // If the given environment is just a Closure, we will defer the environment
    // detection to the Closure the developer has provided, which allows them
    // to totally control the web environment detection if they require to.
    if ($environments instanceof Closure)
    {
      return $this['env'] = call_user_func($environments);
    }

    foreach ($environments as $environment => $hosts)
    {
      // To determine the current environment, we'll simply iterate through the
      // possible environments and look for a host that matches this host in
      // the request's context, then return back that environment's names.
      foreach ((array) $hosts as $host)
      {
        if (str_is($host, $base) or $this->isMachine($host))
        {
          return $this['env'] = $environment;
        }
      }
    }

    return $this['env'] = 'production';
  }

  /**
   * Determine if the name matches the machine name.
   *
   * @param  string  $name
   * @return bool
   */
  protected function isMachine($name)
  {
    return str_is($name, gethostname());
  }

  /**
   * Carregador de provedores de serviços
   * @return void
   */
  public function providersBoot(){
    $this->getProviderRepository()->load($this, $this['config']->get('app.providers'));
    foreach (array_unique($this->deferredServices) as $provider)
    {
      $this->register($instance = new $provider($this));
    }
    foreach ($this->serviceProviders as $provider)
    {
      $provider->boot();
    }
  }

  /**
   * Get the service provider repository instance.
   *
   * @return \Lemee\Application\ProviderRepository
   */
  public function getProviderRepository()
  {
    $manifest = APP_ROOT.DS.'app'.DS.'storage'.DS.'meta';
    return new ProviderRepository(new Filesystem, $manifest);
  }

  /**
   * Carrega apelidos "aliases" das classes de app/config/app.yml
   */
  public function aliasLoader(){
    AliasLoader::getInstance($this['config']->get('app.aliases'))->register(); 
  }

  /**
   * Dynamically access application services.
   *
   * @param  string  $key
   * @return mixed
   */
  public function __get($key)
  {
    return $this[$key];
  }

  /**
   * Dynamically set application services.
   *
   * @param  string  $key
   * @param  mixed   $value
   * @return void
   */
  public function __set($key, $value)
  {
    $this[$key] = $value;
  }
}
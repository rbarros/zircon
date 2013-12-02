<?php namespace Zircon\Application;
/**
 * This file is part of the Zircon CMS (http://nocriz.com)
 *
 * Copyright (c) 2013  Zircon CMS (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

/**
 * Classe AliasLoader
 * Responsavel pelo carregamento das Illuminate.
 * 
 * @author Ramon Barros <contato@ramon-barros.com>
 *
 */
class AliasLoader {

    /**
     * O array contendo os aliases das classe Illuminate
     *
     * @var array
     */
    protected $aliases;

    /**
     * Indica se um loader foi registrado.
     *
     * @var bool
     */
    protected $registered = false;

    /**
     * A instância singleton do loader.
     *
     * @var \Lemee\Application\AliasLoader
     */
    protected static $instance;

    /**
     * Cria uma nova instância do loader com os alias.
     *
     * @param  array  $aliases
     * @return void
     */
    public function __construct(array $aliases = array())
    {
        $this->aliases = $aliases;
    }

    /**
     * Recupera ou cria uma instância do loader singleton com alias.
     *
     * @param  array  $aliases
     * @return \Lemee\Application\AliasLoader
     */
    public static function getInstance(array $aliases = array())
    {
        if (is_null(static::$instance)) static::$instance = new static($aliases);
        
        $aliases = array_merge(static::$instance->getAliases(), $aliases);

        static::$instance->setAliases($aliases);

        return static::$instance;
    }

    /**
     * Carrega o alias da class verifica se está registrado.
     *
     * @param  string  $alias
     * @return void
     */
    public function load($alias)
    {
        if (isset($this->aliases[$alias]))
        {
            return class_alias($this->aliases[$alias], $alias);
        }
    }

    /**
     * Adiciona um alias no loader "carregamento".
     *
     * @param  string  $class
     * @param  string  $alias
     * @return void
     */
    public function alias($class, $alias)
    {
        $this->aliases[$class] = $alias;
    }

    /**
     * Registrar o loader na fila de carregamento.
     *
     * @return void
     */
    public function register()
    {
        if ( ! $this->registered)
        {
            $this->prependToLoaderStack();

            $this->registered = true;
        }
    }

    /**
     * Registra a função na pilha de __autoload da SPL.
     *
     * @return void
     */
    protected function prependToLoaderStack()
    {
        spl_autoload_register(array($this, 'load'), true, true);
    }

    /**
     * Retorna os alias registrados.
     *
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Seta os alias registrados.
     *
     * @param  array  $aliases
     * @return void
     */
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * Indica se o loader "carregador" foi registrado.
     *
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * Define o estado "registrado" do loader "carregador".
     *
     * @param  bool  $value
     * @return void
     */
    public function setRegistered($value)
    {
        $this->registered = $value;
    }

    /**
     * Define o valor do alias do carregador singleton.
     *
     * @param  \Lemee\Application\AliasLoader  $loader
     * @return void
     */
    public static function setInstance($loader)
    {
        static::$instance = $loader;
    }

}

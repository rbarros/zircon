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
 * Classe UpCommand
 * Retorna a aplicação da manutenção.
 * 
 * @author Ramon Barros <contato@ramon-barros.com>
 *
 */
class UpCommand {

    /**
     * Instância da aplicação
     * @var object
     */
    protected $app;

    /**
     * Resposta do comando.
     *
     * @var string
     */
    protected $description = "Bring the application out of maintenance mode";

    /**
     * Construtor seta a instância da aplicação
     * @param Application $app [description]
     */
    public function __construct(Application $app){
        $app = $app;
    }

    /**
     * Retorna a aplicação do modo de manutenção.
     *
     * @return void
     */
    public function fire()
    {
        @unlink($this->laravel['path.storage'].'/meta/down');

        return 'Application is now live.';
    }

}
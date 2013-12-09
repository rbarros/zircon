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
 * Classe utitlizada na API
 * Retorna informações do Cliente.
 * Somente usuários admin tem acesso
 * 
 * @author Ramon Barros <contato@ramon-barros.com>
 */
class Customers
{
    /**
     * @url GET /
     * @url GET /{id}
     * @status 200
     * @param string $id {@from body} {@min 1} Get id
     * @return [type]     [description]
     */
    public function get($id=null)
    {
        return array("clientes get {$id}");
    }

    /**
     * @url POST /
     * @status 200
     * @return [type]     [description]
     */
    public function post($request_data = NULL)
    {
        return array('clientes post' => $request_data);
    }

    /**
     * @url PUT /{id}
     * @status 200
     * @return [type]     [description]
     */
    public function put($id, $request_data = NULL)
    {   
        return array("clientes put {$id}" => $request_data);
    }

    /**
     * @url DELETE /{id}
     * @status 200
     * @param string $id {@from body} {@min 1} Get id
     * @return [type]     [description]
     */
    public function delete($id)
    {
        return array("clientes delete {$id}");
    }
}
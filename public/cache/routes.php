<?php $o = array();

// ** THIS IS AN AUTO GENERATED FILE. DO NOT EDIT MANUALLY ** 

//==================== v1/customers ====================

$o['v1/customers'] = array();

//==== v1/customers GET ====

$o['v1/customers']['GET'] = array (
    'url' => 'v1/customers',
    'className' => 'Customers',
    'path' => 'v1/customers',
    'methodName' => 'get',
    'arguments' => 
    array (
        'id' => 0,
    ),
    'defaults' => 
    array (
        0 => NULL,
    ),
    'metadata' => 
    array (
        'description' => '',
        'longDescription' => '',
        'url' => 0,
        'status' => 200,
        'param' => 
        array (
            0 => 
            array (
                'type' => 'string',
                'name' => 'id',
                'description' => 'Get id',
                'properties' => 
                array (
                    'from' => 'body',
                    'min' => '1',
                ),
                'default' => NULL,
                'required' => false,
                'children' => 
                array (
                ),
                'from' => 'body',
            ),
        ),
        'return' => 
        array (
            'type' => '[type]',
            'description' => '[description]',
        ),
        'author' => 
        array (
            0 => 
            array (
                'email' => 'contato@ramon-barros.com',
                'name' => 'Ramon Barros',
            ),
        ),
        'resourcePath' => 'v1/customers/',
        'classDescription' => 'Classe utitlizada na API Retorna informações do Cliente.',
    ),
    'accessLevel' => 0,
);

//==== v1/customers POST ====

$o['v1/customers']['POST'] = array (
    'url' => 'v1/customers',
    'className' => 'Customers',
    'path' => 'v1/customers',
    'methodName' => 'post',
    'arguments' => 
    array (
        'request_data' => 0,
    ),
    'defaults' => 
    array (
        0 => NULL,
    ),
    'metadata' => 
    array (
        'description' => '',
        'longDescription' => '',
        'url' => 'POST /',
        'status' => 200,
        'return' => 
        array (
            'type' => '[type]',
            'description' => '[description]',
        ),
        'author' => 
        array (
            0 => 
            array (
                'email' => 'contato@ramon-barros.com',
                'name' => 'Ramon Barros',
            ),
        ),
        'resourcePath' => 'v1/customers/',
        'classDescription' => 'Classe utitlizada na API Retorna informações do Cliente.',
        'param' => 
        array (
            0 => 
            array (
                'name' => 'request_data',
                'default' => NULL,
                'required' => false,
                'children' => 
                array (
                ),
                'from' => 'body',
            ),
        ),
    ),
    'accessLevel' => 0,
);

//==================== v1/customers/{s0} ====================

$o['v1/customers/{s0}'] = array();

//==== v1/customers/{s0} GET ====

$o['v1/customers/{s0}']['GET'] = array (
    'url' => 'v1/customers/{id}',
    'className' => 'Customers',
    'path' => 'v1/customers',
    'methodName' => 'get',
    'arguments' => 
    array (
        'id' => 0,
    ),
    'defaults' => 
    array (
        0 => NULL,
    ),
    'metadata' => 
    array (
        'description' => '',
        'longDescription' => '',
        'url' => 0,
        'status' => 200,
        'param' => 
        array (
            0 => 
            array (
                'type' => 'string',
                'name' => 'id',
                'description' => 'Get id',
                'properties' => 
                array (
                    'from' => 'body',
                    'min' => '1',
                ),
                'default' => NULL,
                'required' => false,
                'children' => 
                array (
                ),
                'from' => 'path',
            ),
        ),
        'return' => 
        array (
            'type' => '[type]',
            'description' => '[description]',
        ),
        'author' => 
        array (
            0 => 
            array (
                'email' => 'contato@ramon-barros.com',
                'name' => 'Ramon Barros',
            ),
        ),
        'resourcePath' => 'v1/customers/',
        'classDescription' => 'Classe utitlizada na API Retorna informações do Cliente.',
    ),
    'accessLevel' => 0,
);

//==== v1/customers/{s0} PUT ====

$o['v1/customers/{s0}']['PUT'] = array (
    'url' => 'v1/customers/{id}',
    'className' => 'Customers',
    'path' => 'v1/customers',
    'methodName' => 'put',
    'arguments' => 
    array (
        'id' => 0,
        'request_data' => 1,
    ),
    'defaults' => 
    array (
        0 => NULL,
        1 => NULL,
    ),
    'metadata' => 
    array (
        'description' => '',
        'longDescription' => '',
        'url' => 'PUT /{id}',
        'status' => 200,
        'return' => 
        array (
            'type' => '[type]',
            'description' => '[description]',
        ),
        'author' => 
        array (
            0 => 
            array (
                'email' => 'contato@ramon-barros.com',
                'name' => 'Ramon Barros',
            ),
        ),
        'resourcePath' => 'v1/customers/',
        'classDescription' => 'Classe utitlizada na API Retorna informações do Cliente.',
        'param' => 
        array (
            0 => 
            array (
                'name' => 'id',
                'default' => NULL,
                'required' => true,
                'children' => 
                array (
                ),
                'from' => 'path',
            ),
            1 => 
            array (
                'name' => 'request_data',
                'default' => NULL,
                'required' => false,
                'children' => 
                array (
                ),
                'from' => 'body',
            ),
        ),
    ),
    'accessLevel' => 0,
);

//==== v1/customers/{s0} DELETE ====

$o['v1/customers/{s0}']['DELETE'] = array (
    'url' => 'v1/customers/{id}',
    'className' => 'Customers',
    'path' => 'v1/customers',
    'methodName' => 'delete',
    'arguments' => 
    array (
        'id' => 0,
    ),
    'defaults' => 
    array (
        0 => NULL,
    ),
    'metadata' => 
    array (
        'description' => '',
        'longDescription' => '',
        'url' => 'DELETE /{id}',
        'status' => 200,
        'param' => 
        array (
            0 => 
            array (
                'type' => 'string',
                'name' => 'id',
                'description' => 'Get id',
                'properties' => 
                array (
                    'from' => 'body',
                    'min' => '1',
                ),
                'default' => NULL,
                'required' => true,
                'children' => 
                array (
                ),
                'from' => 'path',
            ),
        ),
        'return' => 
        array (
            'type' => '[type]',
            'description' => '[description]',
        ),
        'author' => 
        array (
            0 => 
            array (
                'email' => 'contato@ramon-barros.com',
                'name' => 'Ramon Barros',
            ),
        ),
        'resourcePath' => 'v1/customers/',
        'classDescription' => 'Classe utitlizada na API Retorna informações do Cliente.',
    ),
    'accessLevel' => 0,
);

//==================== v1/say/hello/{s0} ====================

$o['v1/say/hello/{s0}'] = array();

//==== v1/say/hello/{s0} GET ====

$o['v1/say/hello/{s0}']['GET'] = array (
    'url' => 'v1/say/hello/{to}',
    'className' => 'Say',
    'path' => 'v1/say',
    'methodName' => 'hello',
    'arguments' => 
    array (
        'to' => 0,
    ),
    'defaults' => 
    array (
        0 => 'world',
    ),
    'metadata' => 
    array (
        'resourcePath' => 'v1/say/',
        'param' => 
        array (
            0 => 
            array (
                'name' => 'to',
                'default' => 'world',
                'required' => false,
                'children' => 
                array (
                ),
                'from' => 'query',
            ),
        ),
    ),
    'accessLevel' => 0,
);

//==================== v1/say/hi/{s0} ====================

$o['v1/say/hi/{s0}'] = array();

//==== v1/say/hi/{s0} GET ====

$o['v1/say/hi/{s0}']['GET'] = array (
    'url' => 'v1/say/hi/{to}',
    'className' => 'Say',
    'path' => 'v1/say',
    'methodName' => 'hi',
    'arguments' => 
    array (
        'to' => 0,
    ),
    'defaults' => 
    array (
        0 => NULL,
    ),
    'metadata' => 
    array (
        'resourcePath' => 'v1/say/',
        'param' => 
        array (
            0 => 
            array (
                'name' => 'to',
                'default' => NULL,
                'required' => true,
                'children' => 
                array (
                ),
                'from' => 'path',
            ),
        ),
    ),
    'accessLevel' => 0,
);
return $o;
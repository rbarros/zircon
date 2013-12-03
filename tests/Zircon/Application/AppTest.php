<?php

use Zircon\Application\App;
use Zircon\AbstractTest as AbstractTest;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class AppTest extends AbstractTest
{
    public $instance;

    /**
     * Antes de cada teste verifica se a classe existe
     * e cria uma instancia da mesma
     * @return void
     */
    public function assertPreConditions()
    {   
        $this->assertTrue(
                class_exists($class = 'Zircon\Application\App'),
                'Class not found: '.$class
        );
        $this->instance = new App();
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $this->assertInstanceOf('Zircon\Application\App', $this->instance);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetInstanceKeyWithValidDataShouldWork()
    {
        $this->assertEquals(1, App::VERSION, 'Attribute was not correctly set');
        $this->assertEquals('Zircon API', App::APPNAME, 'Attribute was not correctly set');
        $this->assertEquals('v1.0.0', App::APPVERSION, 'Attribute was not correctly set');
        $this->assertEquals($this->instance, new App, 'Attribute was not correctly set');
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetInstanceConfigWithValidDataShouldWork()
    {
        $config = new Repository($this->instance->getConfigLoader(), 'development');
        $this->assertEquals($this->instance['path'], realpath($config->get('path.app')), 'Attribute was not correctly set');
        $this->assertEquals($this->instance['path.base'], realpath($config->get('path.base')), 'Attribute was not correctly set');
        $this->assertEquals($this->instance['path.public'], realpath($config->get('path.public')), 'Attribute was not correctly set');
        $this->assertEquals($this->instance['path.storage'], realpath($config->get('path.storage')), 'Attribute was not correctly set');
    }
}
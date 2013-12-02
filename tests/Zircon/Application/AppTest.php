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
    public function testSetInstanceKeyWithValidDataShouldWork()
    {
        $config = new Repository($this->instance->getConfigLoader(), 'development');
       $comp = array(
             'app' => $this->instance
            ,'config' => $config
            ,'request' => Request::createFromGlobals()
            ,'path' => false
            ,'path.base' => '/'
            ,'path.public' => false
            ,'path.storage' => false
        );
       $this->assertAttributeEquals($comp, 'instances', $this->instance, 'Attribute was not correctly set');
    }
}
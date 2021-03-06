<?php namespace Zircon\Application;
/**
 * This file is part of the Zircon CMS (http://nocriz.com)
 *
 * Copyright (c) 2013  Zircon CMS (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

use Illuminate\Filesystem\Filesystem;

class ProviderRepository {

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The path to the manifest.
     *
     * @var string
     */
    protected $manifestPath;

    /**
     * Create a new service repository instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(Filesystem $files, $manifestPath)
    {
        $this->files = $files;
        $this->manifestPath = $manifestPath;
    }

    /**
     * Register the application service providers.
     *
     * @param  \Zircon\Application\App  $app
     * @param  array  $providers
     * @param  string  $path
     * @return void
     */
    public function load(App $app, array $providers)
    {
        $manifest = $this->loadManifest();

        // First we will load the service manifest, which contains information on all
        // service providers registered with the application and which services it
        // provides. This is used to know which services are "deferred" loaders.
        if ($this->shouldRecompile($manifest, $providers))
        {
            $manifest = $this->compileManifest($app, $providers);   
        }

        // We will go ahead and register all of the eagerly loaded providers with the
        // application so their services can be registered with the application as
        // a provided service. Then we will set the deferred service list on it.
        foreach ($manifest['eager'] as $provider)
        {
            $app->register($this->createProvider($app, $provider));
        }

        $app->setDeferredServices($manifest['deferred']);
    }

    /**
     * Compile the application manifest file.
     *
     * @param  \Zircon\Application\App  $app
     * @param  array  $providers
     * @return array
     */
    protected function compileManifest(App $app, $providers)
    {
        // The service manifest should contain a list of all of the providers for
        // the application so we can compare it on each request to the service
        // and determine if the manifest should be recompiled or is current.
        $manifest = $this->freshManifest($providers);

        foreach ($providers as $provider)
        {
            $instance = $this->createProvider($app, $provider);

            // When recompiling the service manifest, we will spin through each of the
            // providers and check if it's a deferred provider or not. If so we'll
            // add it's provided services to the manifest and note the provider.
            if ($instance->isDeferred())
            {
                foreach ($instance->provides() as $service)
                {
                    $manifest['deferred'][$service] = $provider;
                }
            }

            // If the service providers are not deferred, we will simply add it to an
            // of eagerly loaded providers that will be registered with the app on
            // each request to the applications instead of being lazy loaded in.
            else
            {
                $manifest['eager'][] = $provider;
            }
        }

        return $this->writeManifest($manifest);
    }

    /**
     * Create a new provider instance.
     *
     * @param  \Zircon\Application\App  $app
     * @param  string  $provider
     * @return \Illuminate\Support\ServiceProvider
     */
    public function createProvider(App $app, $provider)
    {
        return new $provider($app);
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @param  array  $manifest
     * @param  array  $providers
     * @return bool
     */
    public function shouldRecompile($manifest, $providers)
    {
        return is_null($manifest) or $manifest['providers'] != $providers;
    }

    /**
     * Load the service provider manifest JSON file.
     *
     * @return array
     */
    public function loadManifest()
    {
        $path = $this->manifestPath.'/services.json';

        // The service manifest is a file containing a JSON representation of every
        // service provided by the application and whether its provider is using
        // deferred loading or should be eagerly loaded on each request to us.
        if ($this->files->exists($path))
        {
            return json_decode($this->files->get($path), true);
        }
    }

    /**
     * Write the service manifest file to disk.
     *
     * @param  array  $manifest
     * @return array
     */
    public function writeManifest($manifest)
    {
        $path = $this->manifestPath.'/services.json';

        $this->files->put($path, json_encode($manifest));

        return $manifest;
    }

    /**
     * Get the manifest file path.
     *
     * @param  \Zircon\Application\App  $app
     * @return string
     */
    protected function getManifestPath($app)
    {
        return $this->manifestPath;
    }

    /**
     * Create a fresh manifest array.
     *
     * @param  array  $providers
     * @return array
     */
    protected function freshManifest(array $providers)
    {
        list($eager, $deferred) = array(array(), array());

        return compact('providers', 'eager', 'deferred');
    }

    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->files;
    }

}
<?php

namespace App;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

class ResourceRegistrar extends BaseResourceRegistrar
{
    protected $resourceDefaults = ['index', 'create', 'edit', 'store', 'show', 'showAll', 'showTrashed', 'recoveryTrashed', 'update', 'updateAll', 'destroy', 'forceDestroy', 'attach', 'detach', 'sync'];

   
    protected function addResourceShowAll($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'showAll', $options);

        return $this->router->get("$uri.showAll", $action);
    }

    protected function addResourceShowTrashed($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'showTrashed', $options);

        return $this->router->get("$uri.showTrashed", $action);
    }

    protected function addResourceRecoveryTrashed($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'recoveryTrashed', $options);

        return $this->router->get("$uri.recoveryTrashed", $action);
    }

    /**
     * Add the update method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceUpdate($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'update', $options);

        return $this->router->match(['PUT', 'PATCH'], $uri, $action);
    }

    protected function addResourceUpdateAll($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'updateAll', $options);

        return $this->router->match(['PUT', 'PATCH'], "$uri.updateAll", $action);
    }

    /**
     * Add the destroy method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDestroy($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'destroy', $options);

        return $this->router->delete($uri, $action);
    }

    protected function addResourceForceDestroy($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'forceDestroy', $options);

        return $this->router->delete("$uri.forceDestroy", $action);
    }

    /**
     * Add the test method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceTest($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name);

        $action = $this->getResourceAction($name, $controller, 'test', $options);

        return $this->router->post("$uri/ta", $action);
    }

    protected function addResourceAttach($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'.attach/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'attach', $options);

        return $this->router->post("$uri", $action);
    }

    protected function addResourceDetach($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'.detach/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'detach', $options);

        return $this->router->post("$uri", $action);
    }

    protected function addResourceSync($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'.sync/{'.$base.'}';

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'sync', $options);

        return $this->router->post("$uri", $action);
    }




}
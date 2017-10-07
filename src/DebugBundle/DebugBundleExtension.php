<?php

namespace App\DebugBundle;

use App\DebugBundle\Commands\AppServerCommand;
use Bolt\Extension\SimpleExtension;
use Pimple as Container;

class DebugBundleExtension extends SimpleExtension
{
    protected function registerNutCommands(Container $container)
    {
        return [
            new AppServerCommand()
        ];
    }
}
<?php

namespace App\DebugBundle;

use App\DebugBundle\Commands\AppServerCommand;
use Bolt\Extension\SimpleExtension;
use Pimple as Container;

/**
 * Extension to provide basic debug functionality.
 */
class DebugBundleExtension extends SimpleExtension
{
    /**
     * @inheritdoc
     */
    protected function registerNutCommands(Container $container)
    {
        return [
            new AppServerCommand()
        ];
    }
}

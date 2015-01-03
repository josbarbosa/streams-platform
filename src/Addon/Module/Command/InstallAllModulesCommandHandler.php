<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;

/**
 * Class InstallAllModulesCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallAllModulesCommandHandler
{

    /**
     * The module manager.
     *
     * @var ModuleManager
     */
    protected $manager;

    /**
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new InstallAllModulesCommandHandler instance.
     *
     * @param ModuleManager $service
     */
    public function __construct(ModuleCollection $modules, ModuleManager $service)
    {
        $this->manager = $service;
        $this->modules = $modules;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->modules->all() as $module) {
            $this->installModule($module);
        }
    }

    /**
     * Install a module.
     *
     * @param Module $module
     */
    protected function installModule(Module $module)
    {
        $this->manager->install($module->getSlug());
    }
}

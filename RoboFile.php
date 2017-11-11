<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    /**
     * Launch php built-in server
     */
    public function developmentServer()
    {
        $this->taskServer()->dir('public')->arg('public/index.php')->run();
    }

    /**
     * Launch php-cs-fixer for source files.
     *
     * @param string $directory Directory with files to be processed.
     */
    public function developmentFix($directory = 'src')
    {
        $this->taskExec('php-cs-fixer fix')->arg($directory)->run();
    }

    /**
     * Deploy application.
     */
    public function developmentDeploy()
    {
        $this->taskExec('dep')->dir('vendor/bin')->arg('deploy')->arg('production')->run();
    }

    public function assetCompile()
    {
        $this->taskWatch()
            ->monitor('public/theme/materialize/_scss', function () {
                $this->taskScss([
                    'public/theme/materialize/_scss/materialize.scss' => 'public/theme/materialize/css/materialize.css'
                ])
                    ->importDir('public/theme/materialize/_scss')
                    ->run();

                $this->taskMinify('public/theme/materialize/css/materialize.css')
                    ->to('public/theme/materialize/css/materialize.min.css')
                    ->run();
            })
            ->monitor('public/theme/materialize/_js', function () {
                $this->taskConcat(['public/theme/materialize/_js/*.js'])->to('public/theme/materialize/js/app.js')->run();
            })
            ->run();
    }
}
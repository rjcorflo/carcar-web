<?php

namespace App\Google;

use App\Google\Service\DataLayer;
use Bolt\Asset\Snippet\Snippet;
use Bolt\Asset\Target;
use Bolt\Extension\SimpleExtension;
use Silex\Application;

class GoogleBundle extends SimpleExtension
{
    /**
     * @var DataLayer
     */
    private $dataLayer;

    /**
     * @inheritdoc
     */
    protected function registerServices(Application $app)
    {
        $app['google.datalayer'] = $app->share(
            function (Application $app) {
                return new DataLayer();
            }
        );
    }

    /**
     * @inheritdoc
     */
    protected function registerTwigFunctions()
    {
        return [
           'datalayer_push' => 'dataLayerPush'
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerAssets()
    {
        $assets = [];

        $config = $this->getConfig();

        if ($config['container_id'] != '') {
            $assets[] = Snippet::create()
                ->setCallback([$this, 'insertAnalyticsInHead'])
                ->setLocation(Target::BEFORE_HEAD_META)
                ->setPriority(50);

            $assets[] = Snippet::create()
                ->setCallback([$this, 'insertDataLayer'])
                ->setLocation(Target::START_OF_HEAD)
                ->setPriority(1);

            $assets[] = Snippet::create()
                ->setCallback([$this, 'insertAnalyticsInBody'])
                ->setLocation(Target::START_OF_BODY)
                ->setPriority(99);
        }

        return $assets;
    }

    /**
     * @inheritdoc
     */
    public function boot(Application $app)
    {
        $this->dataLayer = $app['google.datalayer'];
    }

    /**
     * @return string
     */
    public function insertDataLayer()
    {
        return $this->dataLayer->getDataLayerScript();
    }

    /**
     * @return string
     */
    public function insertAnalyticsInHead()
    {
        $config = $this->getConfig();

        $variables = ['container_id' => $config['container_id']];

        return $this->renderTemplate('tags/head.twig', $variables);
    }

    /**
     * @return string
     */
    public function insertAnalyticsInBody()
    {
        $config = $this->getConfig();
        $variables = ['container_id' => $config['container_id']];

        return $this->renderTemplate('tags/body.twig', $variables);
    }

    /**
     * @return array
     */
    protected function getDefaultConfig()
    {
        return [
            'container_id' => ''
        ];
    }

    /**
     * @param array $data
     */
    public function dataLayerPush(array $data)
    {
        $this->dataLayer->pushDataArray($data);
    }
}

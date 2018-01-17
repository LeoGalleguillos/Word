<?php
namespace LeoGalleguillos\WordTest;

use LeoGalleguillos\Word\Module;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;

class ModuleTest extends TestCase
{
    protected function setUp()
    {
        $this->module = new Module();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Module::class, $this->module);
    }

    public function testGetServiceConfig()
    {
        $applicationConfig = include(__DIR__ . '/../config/application.config.php');
        $localConfig       = include(__DIR__ . '/../config/autoload/local.php');
        $serviceConfig     = $this->module->getServiceConfig();

        $serviceManager = new ServiceManager();
        $serviceManager->configure($applicationConfig);
        $serviceManager->configure($serviceConfig);
        //$serviceManager->get(\LeoGalleguillos\Word\Model\Service\Thesaurus::class);

        $serviceConfigFactories = $serviceConfig['factories'];
        foreach ($serviceConfigFactories as $className => $value) {
            $this->assertTrue(class_exists($className));
        }
    }
}

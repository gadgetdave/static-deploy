<?php

/**
 * Enter description here ...
 * @author kingd
 */
abstract class MyAppTestCase
    extends \PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * Browser config
     *
     * @var array
     */
    public static $browsers = [
        // Browserstack
//         [
//             'browserName' => 'chrome',
//             'host' => 'hub.browserstack.com',
//             'port' => 80,
//             'desiredCapabilities' => [
//                 'version' => '30',
//                 'browserstack.user' => BROWSERSTACK_USER,
//                 'browserstack.key' => BROWSERSTACK_KEY,
//                 'os' => 'Windows',
//                 'os_version' => '8.1'
//             ]
//         ],
         [
            'browserName' => 'firefox',
            'host' => 'hub.browserstack.com',
            'port' => 80,
            'desiredCapabilities' => [
                'version' => '32',
                'browserstack.user' => BROWSERSTACK_USER,
                'browserstack.key' => BROWSERSTACK_KEY,
                'browserstack.local' => true,
                'os' => 'Windows',
                'os_version' => '8.1'
            ]
        ],
//         [
//             'browserName' => 'internet explorer',
//             'host' => 'hub.browserstack.com',
//             'port' => 80,
//             'desiredCapabilities' => [
//                 'version' => '8',
//                 'browserstack.user' => BROWSERSTACK_USER,
//                 'browserstack.key' => BROWSERSTACK_KEY,
//                 'os' => 'Windows',
//                 'os_version' => '7'
//             ]
//         ],
//         [
//             'browserName' => 'internet explorer',
//             'host' => 'hub.browserstack.com',
//             'port' => 80,
//             'desiredCapabilities' => [
//                 'version' => '9',
//                 'browserstack.user' => BROWSERSTACK_USER,
//                 'browserstack.key' => BROWSERSTACK_KEY,
//                 'os' => 'Windows',
//                 'os_version' => '7'
//             ]
//         ],
        [
            'browserName' => 'internet explorer',
            'host' => 'hub.browserstack.com',
            'port' => 80,
            'desiredCapabilities' => [
                'version' => '10',
                'browserstack.user' => BROWSERSTACK_USER,
                'browserstack.key' => BROWSERSTACK_KEY,
                'browserstack.local' => true,
                'os' => 'Windows',
                'os_version' => '7'
            ]
        ],
//         [
//             'browserName' => 'internet explorer',
//             'host' => 'hub.browserstack.com',
//             'port' => 80,
//             'desiredCapabilities' => [
//                 'version' => '11',
//                 'browserstack.user' => BROWSERSTACK_USER,
//                 'browserstack.key' => BROWSERSTACK_KEY,
//                 'os' => 'Windows',
//                 'os_version' => '8.1'
//             ]
//         ],
         
//         // local selenium
//         [
//             'name' => 'Firefox on Linux',
//             'browserName' => 'firefox',
//             'host' => 'localhost',
//             'port' => 4444
//         ],
//         [
//             'name' => 'Chrome on XP',
//             'browserName' => 'firefox',
//             'host' => 'seleniumrc03',
//             'port' => 4444
//         ],
//         [
//             'name' => 'IE on XP',
//             'browserName' => 'iexplore',
//             'host' => 'seleniumrc03',
//             'port' => 4444
//         ]
    ];
    
    /**
     * (non-PHPdoc)
     * @see PHPUnit_Extensions_SeleniumTestCase::runTest()
     */
    protected function runTest()
    {
        // should only run tests on localhost on dev
        if ($this->getHost() != 'localhost' &&
            $this->getHost() != 'seleniumrc03' &&
            $this->getHost() != 'hub.browserstack.com') {
            return;
        }

        $this->setBrowserUrl($url);
        
        $method = get_class($this) . '::' . $this->getName(false);
        
        echo date("\nH:i:s") . ' ';
        echo $method . ' - ';
        echo $this->getBrowser();
        echo " on " . $this->getHost() . " \n";
        parent::runTest();
    }
    
    /**
     * Spit out a status message
     *
     * @param string $message
     */
    protected function statusMessage($message)
    {
        if (!$message) {
            return;
        }
        echo date("H:i:s") . ' - ' . $message . "\n";
    }

    /**
     * Wait for jQuery ajax calls to complete
     *
     * @return void
     *
    protected function _clickAndWaitForAjax($selector)
    {
        $this->click($selector);
        $condition = 'selenium.browserbot.getCurrentWindow().jQuery.active == 0';
        $this->waitForCondition($condition, 5000);
    }

    /**
     * Wait for jQuery ajax calls to complete
     *
     * @return void
     *
    protected function _waitForAjax()
    {
        $condition = 'selenium.browserbot.getCurrentWindow().jQuery.active == 0';
        $this->waitForCondition($condition, 5000);
    }
    
    /**
     * Wait for page to be loaded
     *
     * @param $timeout
     * @return void
     *
    protected function _waitForPageLoad($timeout = 10000)
    {
        $this->waitUntil(function () {
            return ($this->byId('popup') ? true : null);
        }, $timeout);
    }
    
    /**
     * Wait for element by Css
     *
     * @param string $cssSelector
     * @param int $timeout
     * @return void
     */
    protected function waitForElementByCss($cssSelector = null, $timeout = 15000)
    {
        // wait for ajax
        $this->waitUntil(function () use ($cssSelector) {
            return (
                $this->byCssSelector($cssSelector) ?
                true :
                null
           );
        }, $timeout);
    }
    
    /**
     * Wait for element by id
     *
     * @param string $idSelector
     * @param int $timeout
     * @return void
     */
    protected function waitForElementById($idSelector = null, $timeout = 15000)
    {
        // wait for ajax
        $this->waitUntil(function () use ($idSelector) {
            return (
                $this->byId($idSelector) ?
                true :
                null
            );
        }, $timeout);
    }
    
    /**
     * Wait for element by x path
     *
     * @param string $xPathSelector
     * @param int $timeout
     * @return void
     */
    protected function waitForElementByXPath($xPathSelector = null, $timeout = 15000)
    {
        // wait for ajax
        $this->waitUntil(function () use ($xPathSelector) {
            return (
                $this->byXPath($xPathSelector) ?
                true :
                null
            );
        }, $timeout);
    }
    
    /**
     * Rest
     *
     * @return void
     */
    protected function reset($resetDb = false)
    {
        if ($resetDb) {
            $this->resetDb();
        }
        
        $this->cookie()->clear();
        $this->url('/');
        $this->currentWindow()->maximize();
    }
    
    /**
     * _login
     *
     * @return void
     */
    protected function login($runTests = false)
    {
        if ($runTests) {
            
        }
    }

    /**
     * Logout tests
     *
     * @return void
     */
    protected function logout($runTests = false)
    {
        if ($runTests) {
        }
    }
    
    /**
     * Navigate to url test
     *
     * @param string $url
     * @param boolean $runTests
     * @return void
     */
    protected function navigateToUrl($url = null, $runTests = false)
    {
        // Navigate to url
        $this->statusMessage("Navigate to '$url'");
        $this->url($url);
        
        if ($runTests) {
            // Confirm successful navigation to url
            $this->statusMessage('Confirm successful navigation to url');
            $this->assertTrue($this->getBrowserUrl() . $url == $this->url() && $this->byId('popup'));
        }
        
        $this->waitForPageLoad();
    }
    
    /**
     * Check to see if a given alert message matches
     *
     * @param string $message
     * @return boolean
     */
    protected function alertMessageEquals($message)
    {
        return ($this->alertText() == $message);
    }
    
    /**
     * Check given alert message and either accept or cancel
     *
     * @param string $message
     * @param boolean $accept
     * @param string $runTests
     * @param boolean $crm
     */
    protected function handleAlert(
        $message = null,
        $accept = false,
        $runTests = true,
        $crm = true
    ) {
        if ($runTests) {
            // Test if alert message is correct
            $alertText = $this->alertText();
            $statusMessage = preg_replace("/\n/", ' ', $message);
            $this->tatusMessage("Alert message shown and equals '$statusMessage'");
            $this->assertTrue($this->alertMessageEquals($message));
        }
        
        if ($accept) {
            $this->acceptAlert();
        } else {
            $this->dismissAlert();
        }
        
        if ($crm) {
            sleep(2);
            $this->waitForPageLoad();
        }
    }
    
    /**
     * _resetDb
     * @return void
     */
    protected function resetDb() {}
}

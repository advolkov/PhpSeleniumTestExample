<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . "/../pages/BasePage.php");
require_once(__DIR__ . "/../pages/MainPage.php");
require_once(__DIR__ . "/../pages/DashboardPage.php");
require_once(__DIR__ . "/../pages/RegistrationPersonalInfoPage.php");
require_once(__DIR__ . "/../pages/RegistrationPlanPage.php");
require_once(__DIR__ . "/../pages/RegistrationCustomizationPage.php");
require_once(__DIR__ . "/../utils/Logger.php");
require_once(__DIR__ . "/DataGenerator.php");

class MainTestCase extends \PHPUnit_Framework_TestCase
{
    const DRIVER_HOST = 'http://localhost:4444/wd/hub';
    const DEFAULT_SCREENSHOTS_PATH = "logs/screenshot.jpg";

    /** @var WebDriver */
    private $driver;
    /** @var \Logger */
    private static $logger;
    private static $log_path = "logs/tests.log";
    private static $screenshots_path;
    /** @var \MainPage */
    protected $main_page;
    /** @var \RegistrationPersonalInfoPage */
    protected $registration_personal_info_page;
    /** @var \RegistrationPlanPage */
    protected $registration_plan_page;
    /** @var \RegistrationCustomizationPage */
    protected $registration_customization_page;
    /** @var \DashboardPage */
    protected $dashboard_page;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$log_path = str_replace(".log", "_" . date("mdy-His") . ".log", self::$log_path);
        self::$logger = new \Logger(self::$log_path);
    }

    public function setUp()
    {
        parent::setUp();
        $this->driver = RemoteWebDriver::create(self::DRIVER_HOST, DesiredCapabilities::firefox(), 2000);

        $this->main_page = new \MainPage($this->driver);
        $this->dashboard_page = new \DashboardPage($this->driver);
        $this->registration_personal_info_page = new \RegistrationPersonalInfoPage($this->driver);
        $this->registration_plan_page = new \RegistrationPlanPage($this->driver);
        $this->registration_customization_page = new \RegistrationCustomizationPage($this->driver);
    }

    public function tearDown()
    {
        self::$screenshots_path = str_replace(
            ".jpg",
            "_" . $this->getName(false) . "_" . date("mdy-His") . ".jpg",
            self::DEFAULT_SCREENSHOTS_PATH
        );
        $this->driver->takeScreenshot(self::$screenshots_path);
        $this->driver->close();
        $this->driver->quit();
        parent::tearDown();
    }

    public function openMainPage()
    {
        self::$logger->writeMsg("Opening main page");
        $this->main_page->openMainPage();
    }

    public function openRegistrationPage()
    {
        self::$logger->writeMsg("Opening registration page");
        $this->registration_personal_info_page->openRegistrationPage();
    }

    public function selectSignUp()
    {
        self::$logger->writeMsg("Selecting sign up");
        $this->main_page->clickSignUp();
    }

    public function fillUserName($username)
    {
        self::$logger->writeMsg("Filling username: $username");
        $this->registration_personal_info_page->fillUserName($username);
    }

    public function fillUserEmail($email)
    {
        self::$logger->writeMsg("Filling user email: $email");
        $this->registration_personal_info_page->fillUserEmail($email);
    }

    public function fillUserPassword($password)
    {
        self::$logger->writeMsg("Filling user password: $password");
        $this->registration_personal_info_page->fillUserPassword($password);
    }

    public function submitPersonalInfo($error_expected = false)
    {
        self::$logger->writeMsg("Submitting personal information. Error expected: $error_expected");
        $this->registration_personal_info_page->submitPersonalInfo($error_expected);
    }

    public function selectPlan($plan)
    {
        self::$logger->writeMsg("Select personal plan: $plan");
        $this->registration_plan_page->selectPlan($plan);
    }

    public function submitPlan()
    {
        self::$logger->writeMsg("Submit personal plan");
        $this->registration_plan_page->submitPlan();
    }

    public function selectCustomizationOptions($options)
    {
        self::$logger->writeMsg("Select customization options: " . print_r($options, true));
        $this->registration_customization_page->selectCustomizationOptions($options);
    }

    public function submitCustomization()
    {
        self::$logger->writeMsg("Submit customization options");
        $this->registration_customization_page->submitCustomization();
    }

    public function checkMessageDisplayedOnHomePage($message)
    {
        $result = $this->dashboard_page->isTextPresent($message);
        self::$logger->writeMsg("Check message is displayed. Result: $result");
        $this->assertTrue($result);
    }

    public function printErrorsTextToLog()
    {
        $errors = $this->registration_personal_info_page->getErrorsText();
        self::$logger->writeMsg("Get messages captured through not valid fields values. Result: " . print_r($errors, true));
    }
}

<?php

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception\NoSuchElementException;

class BasePage
{
    /**
     * @var \Facebook\WebDriver\WebDriver
     */
    protected $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function openPage($url)
    {
        $this->driver->get($url);
    }

    public function fillForm($selector, $value, $selector_type = 'css')
    {
        $by = WebDriverBy::cssSelector($selector);
        if ($selector_type == 'xpath') $by = WebDriverBy::xpath($selector);
        $this->driver->findElement($by)->sendKeys($value);
    }

    public function waitForElementAppears($selector, $selector_type = "css", $timeout = 60)
    {
        $i = 0;
        while (true) {
            $i++;
            if ($this->isElementPresent($selector, $selector_type)) {
                break;
            }
            if ($i >= $timeout) {
                throw new NoSuchElementException("Timeout has been reached while waiting for element with $selector_type: $selector");
            }
            usleep(20000);
        }
    }

    public function isElementPresent($selector, $selector_type = "css")
    {
        $by = "";
        if ($selector_type == "css") $by = WebDriverBy::cssSelector($selector);
        if ($selector_type == "xpath") $by = WebDriverBy::xpath($selector);
        try {
            $this->driver->findElement($by);
        } catch (NoSuchElementException $e) {
            return false;
        }

        return true;
    }

    public function isTextPresent($text)
    {
        return $this->isElementPresent("//*[contains(text(), '$text')]", "xpath");
    }
}

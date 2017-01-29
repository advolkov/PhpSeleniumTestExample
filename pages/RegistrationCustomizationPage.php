<?php

use Facebook\WebDriver\WebDriverBy;

class RegistrationCustomizationPage extends BasePage
{
    const CUSTOMIZATION_OPTIONS_TITLE_CSS = ".question-title";
    const CUSTOMIZATION_OPTION_XPATH = "//label[contains(., '%s')]";
    const SUBMIT_CUSTOMIZATION_BUTTON_CSS = "input[value='Submit']";

    public function selectCustomizationOptions($options)
    {
        foreach ($options as $option) {
            $options_xpath = sprintf(self::CUSTOMIZATION_OPTION_XPATH, $option);
            $this->driver->findElement(WebDriverBy::xpath($options_xpath))->click();
        }
    }

    public function submitCustomization()
    {
        $this->driver->findElement(WebDriverBy::cssSelector(self::SUBMIT_CUSTOMIZATION_BUTTON_CSS))->click();
        $this->waitForElementAppears(\DashboardPage::GREETING_PHRASE_CSS);
    }
}
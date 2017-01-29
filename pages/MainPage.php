<?php

use Facebook\WebDriver\WebDriverBy;

class MainPage extends BasePage
{
    const MAIN_PAGE_URL = "https://github.com/";
    const SIGN_UP_XPATH = "//*[.='Sign up']";

    public function openMainPage()
    {
        $this->openPage(self::MAIN_PAGE_URL);
    }

    public function clickSignUp()
    {
        $this->driver->findElement(WebDriverBy::xpath(self::SIGN_UP_XPATH))->click();
        $this->waitForElementAppears(\RegistrationPersonalInfoPage::USER_NAME_FIELD_CSS);
    }
}

<?php

use Facebook\WebDriver\WebDriverBy;

class RegistrationPersonalInfoPage extends BasePage
{
    const REGISTRATION_PAGE_URL = "https://github.com/join";
    const USER_NAME_FIELD_CSS = "#user_login";
    const USER_EMAIL_FIELD_CSS = "#user_email";
    const USER_PASSWORD_FIELD_CSS = "#user_password";
    const SUBMIT_REGISTRATION_BUTTON_CSS = "#signup_button";
    const MAIN_ERROR_MESSAGE_CSS = "#signup-form>.flash-error";
    const FIELD_ERROR_MESSAGE_CSS = ".error";

    public function openRegistrationPage()
    {
        $this->openPage(self::REGISTRATION_PAGE_URL);
    }

    public function fillUserName($username)
    {
        $this->fillForm(self::USER_NAME_FIELD_CSS, $username);
    }

    public function fillUserEmail($email)
    {
        $this->fillForm(self::USER_EMAIL_FIELD_CSS, $email);
    }

    public function fillUserPassword($password)
    {
        $this->fillForm(self::USER_PASSWORD_FIELD_CSS, $password);
    }

    public function submitPersonalInfo($error_expected = false)
    {
        $this->driver->findElement(WebDriverBy::cssSelector(self::SUBMIT_REGISTRATION_BUTTON_CSS))->click();
        if (!$error_expected) {
            $this->waitForElementAppears(\RegistrationPlanPage::PERSONAL_PLAN_CHECKBOX_CSS);
            return;
        }
        $this->waitForElementAppears(self::MAIN_ERROR_MESSAGE_CSS);
    }

    public function getErrorsText()
    {
        $result = [];
        $elements = $this->driver->findElements(WebDriverBy::cssSelector(self::FIELD_ERROR_MESSAGE_CSS));
        foreach ($elements as $element) {
            $result[] = $element->getText();
        }

        return $result;
    }
}

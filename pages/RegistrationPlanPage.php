<?php

use Facebook\WebDriver\WebDriverBy;

class RegistrationPlanPage extends BasePage
{
    const PERSONAL_PLAN_CHECKBOX_CSS = ".currency-container";
    const PERSONAL_PLAN_CSS = "input[value='%s']";
    const PERSONAL_PLAN_SUBMIT_BUTTON_CSS = ".js-choose-plan-submit";

    public function selectPlan($plan)
    {
        $plan_checkbox_css = sprintf(self::PERSONAL_PLAN_CSS, $plan);
        $this->driver->findElement(WebDriverBy::cssSelector($plan_checkbox_css))->click();
    }

    public function submitPlan()
    {
        $this->driver->findElement(WebDriverBy::cssSelector(self::PERSONAL_PLAN_SUBMIT_BUTTON_CSS))->click();
        $this->waitForElementAppears(\RegistrationCustomizationPage::CUSTOMIZATION_OPTIONS_TITLE_CSS);
    }
}
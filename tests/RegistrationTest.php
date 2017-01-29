<?php

namespace Facebook\WebDriver;

require_once(__DIR__ . "/../testlib/MainTestCase.php");

class RegistrationTest extends MainTestCase
{
    const
        PERSONAL_PLAN_FREE = "free",
        PERSONAL_PLAN_PRO = "pro";
    const
        CUSTOMIZATION_OPTION_DEVELOPMENT = "Development",
        CUSTOMIZATION_OPTION_RESEARCH = "Research";
    const VERIFICATION_TXT = "Learn Git and GitHub without any code!";
    const CREATING_ACC_ERR_TXT = "There were problems creating your account";

    public function testSuccessfulRegistration()
    {
        $username = \DataGenerator::generateRandomUserName();
        $user_email = \DataGenerator::generateRandomUserEmail();
        $password = \DataGenerator::generateRandomPassword();
        $plan = self::PERSONAL_PLAN_FREE;
        $customization_options = [
            self::CUSTOMIZATION_OPTION_DEVELOPMENT,
            self::CUSTOMIZATION_OPTION_RESEARCH,
        ];

        //in acceptance test the best practice is to repeat real user steps
        $this->openMainPage();
        $this->selectSignUp();
        $this->fillUserName($username);
        $this->fillUserEmail($user_email);
        $this->fillUserPassword($password);
        $this->submitPersonalInfo();
        $this->selectPlan($plan);
        $this->submitPlan();
        $this->selectCustomizationOptions($customization_options);
        $this->submitCustomization();
        $this->checkMessageDisplayedOnHomePage(self::VERIFICATION_TXT);
    }

    public function providerForTestRegistrationWithBadUsername()
    {
        return \DataGenerator::generateBadUserNamesArray();
    }

    /**
     * @param string $bad_username
     * @dataProvider providerForTestRegistrationWithBadUsername
     */
    public function testRegistrationWithBadUsername($bad_username)
    {
        $username = $bad_username;
        $user_email = \DataGenerator::generateRandomUserEmail();
        $password = \DataGenerator::generateRandomPassword();

        $this->openRegistrationPage();
        $this->fillUserName($username);
        $this->fillUserEmail($user_email);
        $this->fillUserPassword($password);
        $this->submitPersonalInfo($error_expected = true);
        $this->checkMessageDisplayedOnHomePage(self::CREATING_ACC_ERR_TXT);

        // as you wish
        $this->printErrorsTextToLog();
    }

    public function providerForTestRegistrationWithBadEmail()
    {
        return \DataGenerator::generateBadEmailsArray();
    }

    /**
     * @param mixed $bad_email
     * @dataProvider providerForTestRegistrationWithBadEmail
     */
    public function testRegistrationWithBadEmail($bad_email)
    {
        $username = \DataGenerator::generateRandomUserName();
        $user_email = $bad_email;
        $password = \DataGenerator::generateRandomPassword();

        $this->openRegistrationPage();
        $this->fillUserName($username);
        $this->fillUserEmail($user_email);
        $this->fillUserPassword($password);
        $this->submitPersonalInfo($error_expected = true);
        $this->checkMessageDisplayedOnHomePage(self::CREATING_ACC_ERR_TXT);

        // as you wish
        $this->printErrorsTextToLog();
    }
}
Simple example of automated tests using Facebook Selenium WebDriver that covers GitHub registration form

Dependencies:
- phpunit
- Facebook WebDriver (https://github.com/facebook/php-webdriver)
- Selenium Server

Running tests:
```$xslt
phpunit tests/RegistrationTest.php
```

Project structure:
- pages/ - contains page object files
- testlib/ - framework files
- utils/ - utilities used in tests
- tests/ - tests files
- logs/ - dir will be created after the first run. contains tests logs and screenshots

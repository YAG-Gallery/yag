Behaviour driven testing
========================

Install Behat
-------------
Install phantomJs using the package management of you choice.
Install composer.
Run `composer install` within this directory.

Run the tests
-------------

Start phantomJs:

	phantomjs --webdriver=8910 --cookies-file=/tmp/phantomCookies

Run the tests:

	vendor/bin/behat -c Behat.yaml Features/

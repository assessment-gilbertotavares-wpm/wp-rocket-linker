# WP Rocket Linker

## Get started
- Have a mysql DB ready and a user.
- Have `svn` installed.
- Run `composer install`
- Run `bash bin/install-wp-tests.sh wordpress_test mysql_user mysql_password localhost latest`
- Run `composer run-tests`
- Run `composer phpcs`
- You can install the plugin on your website.

## Content
* `bin/install-wp-tests.sh`: installer for WordPress tests suite
* `.editorconfig`: config file for your IDE to follow our coding standards
* `.gitattributes`: list of directories & files excluded from export
* `.gitignore`: list of directories & files excluded from versioning
* `composer.json`: Base composer file to customize for the project
* `LICENSE`: License file using GPLv3
* `phpcs.xml`: Base PHP Code Sniffer configuration file to customize for the project
* `README.md`: The readme displayed on Github, to customize for the project

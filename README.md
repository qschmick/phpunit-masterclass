[![PHPUnit Masterclass](https://www.in2it.be/wp-content/uploads/2017/01/in2it-unit-testing-masterclass.jpg)](https://www.in2it.be/training-courses/phpunit-masterclass/)

# In2it Training: PHPUnit Masterclass

This repository is used for [In2it's PHPUnit Masterclass](https://www.in2it.be/training-courses/phpunit-masterclass/) training course. 

## Forking to your own GitHub account

To participate you can fork this repository to your own GitHub account. To learn how to fork, please read the [GitHub documentation](https://help.github.com/articles/fork-a-repo) explaining the forking process.

## Cloning locally

Once you have forked the repository, you need to clone it locally on your computer so you can work with the source code.

```bash
git clone git@github.com:<username>/phpunit-masterclass.git
```

This will create a local copy of the repository in directory `phpunit-masterclass`. Once you go into that directory, you'll see only the following files:

```bash
cd phpunit-masterclass/
ls -a
.git .gitignore composer.json composer.lock LICENSE README.md
```

## Install composer and composer packages

If you don't have [Composer](https://getcomposer.org) installed yet, now is a good time to download it.

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Or download the PHAR package directly at [getcomposer.org/composer.phar](https://getcomposer.org/composer.phar).

Once composer is installed, we can start installing the required packages. We're using `composer` as command, but if you have downloaded the PHAR file, remember to use `php composer.phar` instead.

```bash
composer install
```

## Source code license

This source code is provided for free by In2it as part of [PHPUnit Masterclass](https://www.in2it.be/training-courses/phpunit-masterclass/) and is licensed with [Apache License 2.0](LICENSE). Copyright 2009 - 2017 © [In2it](https://www.in2it.be). All rights reserved.

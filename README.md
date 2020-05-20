# Checker Help Launcher Admin Panel

## INSTALLATION AND CONFIGURATION

------------------------------

1. Pull code in directory
2. Run composer update
3. Rename file web/index-default.php to web/index.php
4. Rename file config/db-default.php to config/db.php
5. Rename file config/db.php with credentials for Database connection
6. Rename file config/params-default.php to config/params.php
7. Rename file web/.htaccess-default to web/.htaccess
8. Run php yii migrate
9. Point your server to "web" folder
10. Add permissions for web/uploads folder

## GENERAL INFORMATION

------------------------------

Based on Yii 2 Basic Project Template  [Yii 2](http://www.yiiframework.com/)

The template contains the basic features including user login/logout.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

## DIRECTORY STRUCTURE

------------------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources

## REQUIREMENTS

------------------------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.

## PACKAGES

------------------------------

(Added in composer.json)

* "dmstr/yii2-adminlte-asset": "^2.1" - Admin LTE bundle for admin panels. Link to bundle - <https://github.com/dmstr/yii2-adminlte-asset.> Link to demo for Admin LTE - <https://adminlte.io/themes/AdminLTE/index.html>
* "kartik-v/yii2-widget-colorinput": "*" - Widget for color picker. Link - <https://github.com/kartik-v/yii2-widget-colorinput.> Demo and doc - <https://demos.krajee.com/widget-details/colorinput>
* "kartik-v/yii2-sortable": "*" - Widget for Drag and Drop sort items. Link - <https://github.com/kartik-v/yii2-sortable>
* "creocoder/yii2-taggable": "~2.0" - Widget for handle tags on BE. Link - <https://github.com/creocoder/yii2-taggable>
* "2amigos/yii2-selectize-widget": "~1.0" - Widget for handle tags on FE. Link - <https://github.com/2amigos/yii2-selectize-widget>
* "yiisoft/yii2-coding-standards": "2.*", - Yii coding standard for code style (it required "squizlabs/php_codesniffer": "^3.0@dev" inside). Link - <https://github.com/yiisoft/yii2-coding-standards>

## CODE STYLE

------------------------------

We user Yii2  Coding Standards (<https://github.com/yiisoft/yii2-coding-standards).> By this link you will find instructions how to install it and run. For current project we add package "yiisoft/yii2-coding-standards": "2.*" to composer for dev env. Configs for Code Sniffer see in file phpcs.xml.dist. For example i run it with command "vendor/bin/phpcs --encoding=utf-8 --extensions=php ." on my local env.

## API

------------------------------

API calls for Help Launcher created with build in Yii2 RESTful API functionality. For adding API layer we use self-contained software unit - "Module" (See details - <https://www.yiiframework.com/doc/guide/2.0/en/structure-modules)>.
Some controllers extend yii\rest\ActiveController - in this case we use Yii2 build in REST Actions. (See details at - <https://www.yiiframework.com/doc/guide/2.0/en/rest-quick-start)>. In case when we need more control on action logic we extend yii\rest\Controller - and create own logic. Extended controller take care about response format. For checking API routing - see config/web.php "urlManager" param.

## ADMIN PANEL

------------------------------

### Admin panel bundle

For launch Admin panel with Yii2 Framework we use Admin LTE bundle -  <https://github.com/dmstr/yii2-adminlte-asset>.

### Main controller

Main controller for admin panel homepage, login, logout etc - controllers/SiteController.php. Each controller set up access rules for actions inside in "behaviors" function. ['?'] - for Guest users, ['@'] - for logged in users.

### User levels

For now we have 2 type of users for Admin panel - Admin and Content Manager. See models/User.php "getUserLevels" function. For keep track on user level access we use function requireAdmin() in components/PermissionsHelper.php

### Forms

Each form has own model with validate rules inside each field (column). (See function "rules" in models. For example in model/Category.php). As each Modal slide has own fields and forms - for this approach we use DynamicModel. (See models/DynamicTemplate.php). Validate rules for modal slides dynamic models setting up in controllers/ModalSlideController.php in function addTemplateValidateRules(). Field names for modal slides we keep hard coded in models/Template.php.

### Assets

For add any new assets like css or js file - need update assets/AppAssets.php file.

### Additional js

Custom functions needed for customize view or run preview mode for modal and slides located in web/js/custom.js.

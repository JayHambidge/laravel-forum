[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Riari/laravel-forum/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Riari/laravel-forum/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Riari/laravel-forum/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Riari/laravel-forum/build-status/master)

**Note: this package is under active development, but should be safe to use for production sites. A demo is available online at http://laravel-forum-demo.ricko.me/ if you want to test it first. You can also use https://github.com/Riari/laravel-forum-demo to get yourself started.**

# Laravel forum package

Note: This is based on the excellent [Laravel forum solution written by Atrakeur](https://github.com/Atrakeur/laravel-forum). It's structured in the same way, but introduces a lot of features and minor improvements throughout.

**For the Laravel 5 version**, see the [laravel-5 branch](https://github.com/Riari/laravel-forum/tree/laravel-5).

## Goals

This package aims to provide a solid basis for implementing a forum in a Laravel application. It focuses on taking care of conventional forum features, allowing you to spend more time building your application and the way in which the forum integrates with it.

In addition to an overridable main controller, the package also provides extensive configuration options including permission callbacks, integration settings and preferences to tune the behaviour of your forum.

## Features

This package is currently under heavy development. Feel free to post issues and features requests at https://github.com/Riari/laravel-forum/issues.

 * Categories with nesting (up to 2 levels) and weighting
 * Threads with locking, pinning and deletion
 * Posts with permalinks, editing and deletion
 * Optional soft-deletion of threads and posts
 * Alert callback (to display success/validation messages using your preferred method)
 * Pagination
 * Basic auth & user integration out of the box
 * Permissions integration with basic defaults:
   * Category access
   * Create threads
   * Delete threads
   * Lock threads
   * Pin threads
   * Reply to threads
   * Edit posts
   * Delete posts
 * Lightweight & fast
 * Default views written with [Bootstrap](http://getbootstrap.com/) compatibility in mind
 * Multilingual (English and French translations available out of the box)

### Planned features
 * Read/unread thread status (with icons and 'new posts' page)

### Demo

You can view a simple demo online at http://laravel-forum-demo.ricko.me/

## Installation

**Important!** Before you proceed, please be aware that user functionality (signup, login, user profiles, etc) is not provided by this package. It only interfaces with your user model and authentication facade (Laravel's built-in one by default) to associate users with their threads/posts. If you need user handling, I recommend these packages:

 * [Zizaco/confide](https://github.com/Zizaco/confide) - for account creation, login, logout, confirmation by e-mail, password reset, etc.
 * [Zizaco/entrust](https://github.com/Zizaco/entrust) - for role-based user permissions.

### Step 1: Import the package

To install, simply add the following line to your composer .json and run composer update:

```json
"riari/laravel-forum": "dev-master"
```

Update your packages:

`composer update`

Then add the following service provider to your app/config/app.php:

```php
'Riari\Forum\ForumServiceProvider',
```

### Step 2: Deploy the controller

Run the forum install command to auto-deploy the forum controller to your app/controllers folder:

`php artisan forum:install`

### Step 3: Update your database

Publish the package migrations:

`php artisan migrate:publish riari/laravel-forum`

Then run your migrations:

`php artisan migrate`

Once complete, you can define your categories and sub-categories in the forum_categories table. The schema is simple, so you should be able to do that on your own using Laravel seeds or straightforward SQL.

Once your categories are set up, go to <app hostname>/forum and you should see a brand new forum.

## Customisation

### Configuration

To adjust configuration (including permissions and integration options), publish the package config files:

`php artisan config:publish riari/laravel-forum`

You'll find them in app/config/packages/riari/laravel-forum.

### Controller methods

You can override any of the methods in the controller (app/controllers/ForumController.php by default) to adjust the behaviour of your forum.

### Views

Publish the package view files to your views folder:

`php artisan view:publish riari/laravel-forum`

You can then adjust the views however you like. I suggest editing the master view to make it extend your app's main layout to easily integrate the forum with your design.

## Important notes

### Regarding permissions

The default permission callbacks don't allow users to perform certain actions such as deleting threads or posts; you'll need to modify them to return TRUE based on your own criteria. For example, if you use [Zizaco/entrust](https://github.com/Zizaco/entrust), you might change your `delete_threads` callback to return `Entrust::can('forum_threads_delete');`, allowing users with a role that grants the `forum_threads_delete` permission to delete threads.

Note that the default set of views include links for deleting, editing and replying, and their visibility is controlled by the permission callbacks.

### Regarding sensitive actions (i.e. moderator tools)

As a security measure, the following actions are by default implemented using inline forms to prevent abuse of your forum:

  * Locking/pinning/deleting threads
  * Deleting posts

This is achieved with a Form macro that generates forms using an anchor in place of the usual submit input/button, which submits the enclosing form via jQuery. See [macros.php](https://github.com/Riari/laravel-forum/blob/master/src/macros.php) for details about the available options for the macro.

To support that, the default master layout loads jQuery via CDN if not already present, and provides rudimentary handling of both "inline form submitters" generated by the macro and confirmation dialogs for deleting threads and posts. You can customise this behaviour simply by overriding the views.

### Regarding translations

I don't know French very well and as such I'm relying heavily on Google Translate to keep the French strings up to date. If I derped on any of them, please let me know so I can fix them!

Also, feel free to provide translations for languages that aren't yet supported. You can find the language files [here](https://github.com/Riari/laravel-forum/tree/master/src/lang).

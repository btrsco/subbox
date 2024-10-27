# Subbox - Stubstack-like blog platform

> Subbox is an application built with Laravel 11 and Vue 3.
> Simple Stubstack-like blog platform that allows users to create and update blog posts, allowing guests to view the posts and subscribe to the blog via email.
> Built as an assessment of my skills as a full-stack developer.

Access a demo version of this application on [subbox.deploy.page](https://subbox.deploy.page).

## Table of Contents

<!-- TOC -->
* [Subbox](#subbox)
  * [Table of Contents](#table-of-contents)
* [Getting Started](#getting-started)
  * [Assumptions](#assumptions)
  * [Installation](#installation)
  * [Database Seeding](#database-seeding)
* [Code Overview](#code-overview)
  * [Dependencies](#dependencies)
  * [Structure](#structure)
  * [Environment Variables](#environment-variables)
  * [Testing](#testing)
<!-- TOC -->

# Getting Started

Below you will find everything you need to get this project installed and
running, as well as any nuances that you may need to be aware of for running
this project.

---

## Assumptions

I assume that you have a basic understanding of Laravel and Vue.js. If you
don't, I recommend you check out the official documentation for
[Laravel 11](laravel-docs) and [Vue 3](vue-docs).

I was using Laravel Herd to handle all base dependencies and configurations 
in my development environment. If you are not using Laravel Herd, you can 
check the official documentation for [Laravel Herd](herd-docs) to see how 
to install it, or you can install some of the dependencies manually. You 
can find a list of all dependencies in the [Dependencies](#dependencies) 
section.

## Installation

Please check the official
[Laravel 11 documentation](laravel-docs) for an installation
guide with the server requirements before you get started.

Clone the repository:

```shell
git clone git@github.com:btrsco/subbox.git
```

Switch to the repo folder:

```shell
cd subbox
```

Install all the composer and npm dependencies:

```shell
composer install
npm install
```

Copy the `.env.example` and generate a new application key:

```shell
cp .env.example .env
php artisan key:generate
```

Run the database migrations **(Set the database connection in .env before
migrating)**:

```shell
php artisan migrate
```

Build the frontend assets, this will also build the SSR assets:

```shell
npm run build
```

You can now run the SSR server:

```shell
php artisan inertia:start-ssr
```

## Database Seeding

Populate the database with seed data with relationships. This can help you to
quickly start testing the application and/or api with realistic data.

Run the database seeder:

```shell
php artisan db:seed
```

This will run the base `/database/seeders/DatabaseSeeder.php` which has a list
of universal, development and production seeders. Comment out the seeders you
don’t need to run.

**Note**: It's recommended to have a clean database before seeding. You can
refresh your migrations at any point to clean the database by running the
following command:

```shell
php artisan migrate:fresh --seed
```

# Code Overview

The following is an overview of the code structure. The structure follows the
Laravel best practices and has been optimized to be as simple as possible. If
you are not familiar with some terms used below, you can read more about them
in the [Laravel 11 documentation](laravel-docs) or the
specific documentation for the dependencies listed below.

---

## Dependencies

All of our current dependencies are listed below. You can find out more about
each of these dependencies by clicking on the links below.

**Base:**

- Development:
  - [`Laravel Herd`](herd-docs): Laravel development environment
- Production:
  - `PHP >= 8.2`: PHP programming language
  - `Composer >= 2.1`: PHP package manager
  - `Node >= 16.0`: JavaScript runtime
  - `NPM >= 7.0`: JavaScript package manager

**Composer:**

- [`laravel/breeze`](https://laravel.com/docs/11.x/starter-kits#laravel-breeze): Simple authentication scaffolding
- [`'itsgoingd/clockwork'`](https://github.com/itsgoingd/clockwork): Debugging package
- [`spatie/typescript-transformer`](https://spatie.be/docs/typescript-transformer/v2/introduction): Typescript transformer for Laravel
- [`tightenco/ziggy`](ziggy-docs): Usable routes in Javascript
- [`lorisleiva/laravel-actions`](https://laravelactions.com/): Classes that handle actions
- [`pestphp/pest`](pest-docs): Minimal PHP testing suite

**Node:**
- [`@inertiajs/vue3`](https://inertiajs.com/): Inertia.js
- [`@vue/server-renderer`](https://v3.vuejs.org/guide/ssr/introduction.html): Vue 3 server renderer
- [`@vueuse/core`](https://vueuse.org/): Collection of essential Vue Composition API utils
- [`axios`](https://axios-http.com/docs/intro): Promise based HTTP client
- [`class-variance-authority`](https://www.npmjs.com/package/class-variance-authority): Class variance authority
- [`clsx`](https://www.npmjs.com/package/clsx): A tiny utility for constructing className strings conditionally
- [`dayjs`](https://day.js.org/): Fast 2kB alternative to Moment.js with the same modern API
- [`lodash`](https://lodash.com/): A modern JavaScript utility library delivering modularity, performance & extras
- [`lucide-vue-next`](https://www.npmjs.com/package/lucide-vue-next): Lucide icons for Vue 3
- [`radix-vue`](https://www.npmjs.com/package/radix-vue): A collection of Vue components and utilities
- [`sass`](https://sass-lang.com/): Sass is the most mature, stable, and powerful professional grade CSS extension language in the world
- [`tailwind-merge`](https://www.npmjs.com/package/tailwind-merge): Tailwind CSS plugin to merge classes
- [`tailwindcss`](https://tailwindcss.com/): Tailwind CSS
- [`typescript`](https://www.typescriptlang.org/): TypeScript
- [`vee-validate`](https://vee-validate.logaretm.com/v4/): Template-based validation framework for Vue.js
- [`vite`](https://vitejs.dev/): Frontend build tool
- [`vue-sonner`](https://www.npmjs.com/package/vue-sonner): A simple and lightweight notification plugin for Vue.js
- [`vue-tsc`](https://www.npmjs.com/package/vue-tsc): A simple and lightweight notification plugin for Vue.js
- [`vue`](https://vuejs.org/): Vue.js
- [`ziggy-js`](ziggy-docs): Usable routes in Javascript
- [`zod`](https://www.npmjs.com/package/zod): TypeScript-first schema declaration and validation library

## Structure

Below is a list of the most important folders in the project and what they are
used for.

- `app/Actions`: Contains all single task action classes
- `app/Enums`: Contains all enum classes
- `app/Helpers`: Contains all helper classes and global helpers functions
- `app/Http/Controllers/Api`: Contains all api controllers
- `app/Http/Controllers`: Contains all web controllers
- `app/Http/Middleware`: Contains all application middleware
- `app/Http/Requests/Api`: Contains all api form requests
- `app/Http/Requests`: Contains all web form requests
- `app/Models`: Contains all Eloquent models
- `app/Repositories`: Contains all repository classes
- `app/Services`: Contains all service classes
- `config`: Contains all the apps config files
- `database/factories`: Contains all model factories
- `database/migrations`: Contains all database migrations
- `database/seeders/Development`: Contains all development seeders
- `database/seeders/Production`: Contains all production seeders
- `database/seeders/Universal`: Contains all universal seeders
- `database/seeders`: Contains all database seeders
- `public`: Contains all public assets
- `resources/scripts/types`: Contains all typescript type declarations
- `resources/scripts`: Contains all javascript files
- `resources/views`: Contains all blade and vue files
- `resources`: Contains all resources
- `routes/api`: Contains all api middleware app routes
- `routes/web`: Contains all web middleware app routes
- `routes`: Contains all app routes
- `tests`: Contains all app tests

## Environment Variables

- `.env`: Environment variables can be set in this file
- `.env.example`: Example file with every possible variable

**Note**: You can quickly set the database information and other variables in
this file and have the application fully working.

## Testing

We use [Pest](pest-docs) for testing. You can run the tests with the following command:

```shell
./vendor/bin/pest
```

[laravel-docs]: https://laravel.com/docs/11.x
[vue-docs]: https://v3.vuejs.org/guide/introduction.html
[herd-docs]: https://herd.laravel.com/docs/1/getting-started/installation
[pest-docs]: https://pestphp.com/docs/installation
[ziggy-docs]: https://github.com/tighten/ziggy

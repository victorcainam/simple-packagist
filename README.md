Simple Packagist
================

[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-packagist.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-packagist)
[![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-packagist/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-packagist)
[![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-packagist/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-packagist)
[![License](https://poser.pugx.org/simplesoftwareio/simple-packagist/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-packagist)
[![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-packagist/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-packagist)
[![StyleCI](https://styleci.io/repos/60654618/shield?branch=develop)](https://styleci.io/repos/60654618)

##This is pre-release software. The API may change.  Use at your own risk.

- [Introduction](#docs-introduction)
- [Installation](#docs-installation)
- [Cache](#docs-cache)
- [Usage](#docs-usage)
- [Advance Usage](#docs-advance-usage)

<a id="docs-introduction"></a>
## Introduction
Simple Packagist is a package for Laravel that retrieves statistics about any of the packages stored on the popular composer website Packagist.  Our aim is to provide an easy-to-use library to access this information.

<a id="docs-installation"></a>
## Installation

#### Composer

First, add Simple Packagist as a `require` in your `composer.json` file:

	"require": {
		"simplesoftwareio/simple-packagist": "dev-master"
	}

After that has been added, run the `composer install` command.

#### Service Provider

###### Laravel 5
Next, register the `SimpleSoftwareIO\QrCode\PackagistServiceProvider::class` in your `config/app.php` within the `providers` array.

#### Aliases

###### Laravel 5
Finally, register the `'Packagist' => SimpleSoftwareIO\QrCode\Facades\Packagist::class` in your `config/app.php` configuration file within the `aliases` array.

<a id="docs-cache"></a>
## Cache

All of the information retrieved from Packagist is stored within your application's configured cache for a default of 60 minutes.  You may configure the amount of time a package is cache for by adding the following to your `config/cache.php` file.

    'packagist' => [
        'length' => 45
    ],

<a id="docs-usage"></a>
## Usage

All methods return a [Laravel Collection.](https://laravel.com/docs/collections)  We highly recommend you read up on collections in order to fully understand them when using this library.

#### All

The `all` method returns a collection of all of the packages stored on Packagist.

    Packagist::all();
    
    // Collection [
        0 => Package [
            'vendor' => 'vendor',
            'package' => 'package'
        ]
        ...
    ]
    
Each `Package` object within the collection can be used to retrieve more information about each individual package.  You can call a variaty of methods such as `get` to retrieve this information.

    Packagist::all()->first()->get();
    
    //Collection {#177 ▼
        #items: array:16 [▼
          "name" => "00f100/cakephp-opauth"
          "description" => "Opauth plugin for CakePHP v3.x, allowing simple plug-n-play 3rd-party authentication with CakePHP"
          "time" => "2015-12-02T20:12:51+00:00"
          "maintainers" => array:1 [▶]
          "versions" => array:1 [▶]
          "type" => "cakephp-plugin"
          "repository" => "https://github.com/00F100/cakephp-opauth"
          "github_stars" => 1
          "github_watchers" => 1
          "github_forks" => 2
          "github_open_issues" => 0
          "language" => "PHP"
          "dependents" => 0
          "suggesters" => 0
          "downloads" => array:3 [▶]
          "favers" => 1
        ]
      }

#### Vendor

You may get all of the packages for a specific vendor by using the `vendor` method.

    Packagist::vendor('simplesoftwareio');
    
    //Collection {#179 ▼
        #items: array:2 [▼
          0 => Package {#186 ▼
            #client: Client {#164 ▶}
            #cache: CacheManager {#161 ▶}
            #endPoint: "https://packagist.org/packages"
            #vendor: "simplesoftwareio"
            #package: "simple-qrcode"
            #namespace: "simple-packagist"
          }
          1 => Package {#187 ▼
            #client: Client {#164 ▶}
            #cache: CacheManager {#161 ▶}
            #endPoint: "https://packagist.org/packages"
            #vendor: "simplesoftwareio"
            #package: "simple-sms"
            #namespace: "simple-packagist"
          }
        ]
      }
      
#### Type

You can get all of the packages of a certain type by using the `type` method.

    Packagist::type('composer');
    
    //Collection {#212 ▼
        #items: array:19 [▼
          0 => Package {#196 ▼
            #client: Client {#164 ▶}
            #cache: CacheManager {#161 ▶}
            #endPoint: "https://packagist.org/packages"
            #vendor: "aseba"
            #package: "curl"
            #namespace: "simple-packagist"
          }
          ...
        ]
      }
      
#### Packages

You may also search the Packagist repository by using the `packages` method.

    Packagist::packages([
        'vendor' => 'simplesoftwareio',
        'type' => 'laravel'
    ]);
        
    //Collection {#201 ▼
        #items: array:2 [▼
          0 => Package {#196 ▼
            #client: Client {#164 ▶}
            #cache: CacheManager {#161 ▶}
            #endPoint: "https://packagist.org/packages"
            #vendor: "simplesoftwareio"
            #package: "simple-qrcode"
            #namespace: "simple-packagist"
          }
          ...
        ]
      }
      
#### Package

Retreiveing a package is also very easy.  Simply use the `package` method and then retrieve the information using the `get` method.

    Packagist::package($vendor, $package)->get();
    Packagist::package('simplesoftwareio', 'simple-qrcode')->get();
    
    //Collection {#178 ▼
        #items: array:16 [▼
          "name" => "simplesoftwareio/simple-qrcode"
          "description" => "Simple QrCode is a QR code generator made for Laravel."
          "time" => "2014-06-09T22:37:43+00:00"
          "maintainers" => array:2 [▶]
          "versions" => array:22 [▶]
          "type" => "library"
          "repository" => "https://github.com/SimpleSoftwareIO/simple-qrcode"
          "github_stars" => 292
          "github_watchers" => 18
          "github_forks" => 64
          "github_open_issues" => 3
          "language" => "PHP"
          "dependents" => 5
          "suggesters" => 0
          "downloads" => array:3 [▶]
          "favers" => 298
        ]
      }
      
<a id="docs-advance-usage"></a>
## Advance Usage

#### Get package information from a list of packages.

`All`, `Vendor`, `Type`, and `Packages` return a Collection of the `Package` object.  These objects can further be used to retrieve additional information about each package by calling the `get` method on them.  Calling the `get` method will fire off an API request to the Packagist servers.

    $packages = Packagist::vendor('simplesoftwareio');

    foreach ($packages as $package)
    {
        $package->get(); //Will retrieve all of the information for each package for this vendor.
    }
    
You can get specific information about a package by calling the appropriate method on the `Package` object.  For instance, you could run the following to get the amount of stars (favers) a package has.

    $packages = Packagist::vendor('simplesoftwareio');

    foreach ($packages as $package)
    {
        $package->favers(); //The amount of stars each repo has.
    }
    
The following is a table of the methods that can currently be called: 

|Method|Data Type|Returns|
|---|---|---|
|name|string|Returns the vendor/package.|
|description|string|Returns the package's description.|
|time|string|Returns the time of the version.|
|maintainers|array|Returns an array of the maintainers of the package.|
|versions|array|Returns an array of version's for the package.  This array contains further information specific to the version number.|
|type|string|The type of package.|
|repository|string|The URL of the package.|
|github_stars|integer|The amount of GitHub stars.|
|github_watchers|integer|The amount of GitHub watchers.|
|github_forks|integer|The amount of GitHub forks.|
|github_open_issues|integer|The amount of GitHub open issues.|
|language|string|The language of the package.|
|dependents|integer|The amount of packages that depend on this package.|
|suggesters|integer|The amount of suggested packages that this package has.|
|downloads|array|An array that contains `total`, `monthly`, and `daily` download counts.|
|favors|integer|The amount of favors that this package has|

#### Getting information for a specific version number

Some methods support the ability to get information for a specific version number.

    Packagist::package('simplesoftwareio', 'simple-qrcode')->description('1.5.0');
    
    //Returns the description for version number 1.5.0 for simplesoftwareio/simple-qrcode
    
The following methods support passing in a version number:

|Method|Data Type|Returns|
|---|---|---|
|name|string|Returns the vendor/package.|
|description|string|Returns the package's description.|
|keywords|string|Returns the keywords.|
|homepage|string|Returns the URL for the homepage.|
|version|string|Returns the version number.|
|version_normalized|string|Returns a normalized version number.|
|license|array|Returns an array of licenses that the package is licensed under.|
|authors|array|Returns an array of authors.|
|source|array|Returns an array that contains the `type`, `url`, and `reference` of this version.|
|dist|array|Returns the `type`, `url`, `reference`, and `shasum` of this version.|
|type|string|Returns the type for this version.|
|time|string|Returns the time that this version was released|
|autoload|array|Returns the type of autoloading that this package uses.|
|require|array|Returns an array of dependencies.|
|require-dev|array|Returns the development dependencies.|

You do not have to use any of these helpers to retrieve the required information for a package.  The return from any of the methods are treated as an array.

    Packagist::package('simplesoftwareio', 'simple-qrcode')->get()['favers']
    //Will return the favors for the given package.
    
    Packagist::package('simplesoftwareio', 'simple-qrcode')->get()['downloads']['total']
    //Will return the total downloads for the package.

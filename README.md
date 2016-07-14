# php-easygit [![Build Status](https://travis-ci.org/andywer/php-easygit.png?branch=master)](https://travis-ci.org/andywer/php-easygit) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/andywer/php-easygit/badges/quality-score.png?s=841fe3e93fbf3f293b08de04e86e6b6179d55fd0)](https://scrutinizer-ci.com/g/andywer/php-easygit/)

Manage Git repositories from within your PHP webapp. No further dependencies. You just need to have PHP 5.3+ and Git installed.

This library is a PHP wrapper around the Git command line tool. You may open, create or clone repositories, get information about it and execute any Git command.


## Installation

To install the library you just need to clone the repository (or add EasyGit as submodule):

```sh
git clone https://github.com/andywer/php-easygit.git
```

Or use composer to use EasyGit in your project. Create the following composer.json:

```json
{
  "require" : {
    "easygit/easygit" : "dev-master"
  }
}
```

And then execute `composer install`. Just add `require_once "vendor/autoload.php";` to your PHP source code.

Done!


## Usage


```php
<?php

require_once 'vendor/easygit/easygit/EasyGit.php';

use \EasyGit\Repository;

// Open an existing git repository
$repo = Repository::open("path/to/repository");

// Create a new empty git repository
$repo = Repository::create("path/to/repository");

// Create a new git repository by cloning one
$repo = Repository::cloneFromUrl("https://github.com/vendor/project.git", "path/to/repository");

// Get the current branch
echo "Current branch: " . $repo->getCurrentBranch() . "\n";

// Get all branches
echo "Branches: " . implode(",", $repo->getBranches()) . "\n";

// Get all tags
echo "Tags: " . implode(",", $repo->getTags()) . "\n";

// Print the output of `git status`
echo $repo->git("status") . "\n";

// The library will raise an exception and provide a useful error message if git encounters an error
echo $repo->git("checkout branch-that-does-not-exist") . "\n";

/* Output:
 * PHP Fatal error:  Uncaught exception 'EasyGit\GitException' with message 'Git invocation failed:
 * git 'checkout' 'branch-that-does-not-exist'. Error: error: pathspec 'branch-that-does-not-exist'
 * did not match any file(s) known to git.' in /tmp/easygit/vendor/easygit/easygit/lib/EasyGit/Command.php:25
 * Stack trace:
 * #0 /tmp/easygit-test/vendor/easygit/easygit/lib/EasyGit/Repository.php(93): EasyGit\Command->run()
 * #1 /tmp/easygit-test/test.php(4): EasyGit\Repository->git('checkout branch...')
 * #2 {main}
 *   thrown in /tmp/easygit-test/vendor/easygit/easygit/lib/EasyGit/Command.php on line 25
 */

?>
```


## PHP Git Repo

EasyGit is quite similar to [PHP Git Repo](https://github.com/ornicar/php-git-repo).
I wrote the EasyGit library since I soon struggled with its limited error handling capabilities and very basic git command invocation using _passthru()_.
_PHP Git Repo_ is quite customizable, but I wanted to have a out-of-the-box solution that suites my needs. It will also be used in a professional environment and I can ensure the neccessary quality of support for my own library.

No offense!


## Development

Feel free to submit your issues and feature requests. You can also participate in the development progress.

If you want to run the tests, you will need to install the atoum unit test library. Just install composer and run it:

```sh
./sh/install-composer.sh
php composer.phar install
```

Tests can be run by executing `./sh/run-tests.sh`.


## License

This library is published under the MIT license. See [license](https://raw.github.com/andywer/php-easygit/master/LICENSE) for details.

Have a lot of fun!


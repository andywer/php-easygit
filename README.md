# php-easygit

Manage Git repository contents from within your PHP webapp. No further dependencies. You just need to have Git installed.


## Installation

To install the library you just need to clone the repository.

```sh
git clone https://github.com/andywer/php-easygit.git
```


## Usage


```php
<?php

require_once 'vendor/easygit/EasyGit.php';

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

?>
```


## PHP Git Repo

EasyGit is quite similar to [PHP Git Repo](https://github.com/ornicar/php-git-repo).
I wrote the EasyGit library since I soon struggled with its limited error handling capabilities and very basic git command invocation using _passthru()_.
_PHP Git Repo_ is quite customizable, but I wanted to have a out-of-the-box solution that suites my needs. It will also be used in a professional environment and I can ensure the neccessary quality of support for my own library.

No offense!


## Development

Feel free to submit your issues and feature requests. You can also participate in the development progress.

If you want to run the tests, you will need to install the atoum unit test library. Just install composer and run `php composer.phar install`:

```sh
./sh/install-composer.sh
php composer.phar install
```

Tests can be run by executing `./sh/run-tests.sh`.


## License

This library is published under the MIT license. See [license](https://raw.github.com/andywer/php-easygit/master/LICENSE) for details.

Have a lot of fun!


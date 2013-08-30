#!/bin/sh

SHDIR=`dirname "$0"`
cd "$SHDIR/.."

if [ ! -f ./bin/atoum ]; then
    echo "Error:    atoum unit testing library not available"
    echo "Solution: Execute './sh/install-composer.sh && php composer.phar install'"
    exit 1
fi

./bin/atoum -d ./tests


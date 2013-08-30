#!/bin/sh

SHDIR=`dirname "$0"`
cd "$SHDIR/.."

curl -sS "https://getcomposer.org/installer" | php


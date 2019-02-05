
#!/usr/bin/env bash

# this wonderful utility runs tests every time a file is saved. 
# https://facebook.github.io/watchman/docs/watchman-make.html
# https://hackernoon.com/automatically-running-phpunit-with-watchman-e02757e733e7
watchman-make -p '**/*.php' --run 'vendor/bin/phpunit tests'
#!/bin/bash
cd /home/work/wyn
source ~/.bashrc
phpunit --verbose tests/ArticleTest
phpunit --verbose tests/LogHelperTest

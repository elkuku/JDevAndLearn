#!/bin/php
<?php

nbVersion=7.1.2
file=netbeans-$nbVersion-ml-php-linux.sh

wget http://download.netbeans.org/netbeans/$nbVersion/final/bundles/$file

chmod +x $file

./$file

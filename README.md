# Solarium Demo

Demo Solr and PHP integration

Uses PHP 7.x, Solarium 5.2.0 and Solr 8.5.x (Java JDK 8 or 11)

## Install Solr

See https://lucene.apache.org/solr/downloads.html

Download zip from Apache solr website, and run it locally as a non-root user on standard port 8983. 
And make sure the server is only accessible via localhost (not for the whole internet)

In the solr directory:

`bin/solr start -Djetty.host=127.0.0.1` 

Create a new 'core'

`bin/solr create_core -c igo`

Edit the solrconfig.xml in server/solr/igo/ to add Tika's extract handler (to extract text from various document formats)

See also https://lucene.apache.org/solr/guide/8_5/uploading-data-with-solr-cell-using-apache-tika.html

Stop and restart Solr

`bin/solr stop -Djetty.host=127.0.0.1` 
`bin/solr start -Djetty.host=127.0.0.1` 

## Install PHP Composer

See https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos

## Install Solarium

See https://solarium.readthedocs.io/en/stable/

Put a new composer.json in an empty directory, and let composer download the required dependencies

`composer.phar install`

Let composer generate the autoload file in vendor/autoload.php

`composer.phar dump-autoload`

## Run test script

`php test.php`

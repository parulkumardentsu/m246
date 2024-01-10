#!/bin/bash
# My first script
# extract the protocol
proto="$(echo $CLEARDB_DATABASE_URL | grep :// | sed -e's,^\(.*://\).*,\1,g')"
# remove the protocol
url="$(echo ${CLEARDB_DATABASE_URL/$proto/})"
# extract the user (if any)
user="$(echo $url | grep @ | cut -d: -f1)"
# remove user from url
tmp=":"
url="$(echo ${url/$user$tmp/})"
# extract the password (if any)
password="$(echo $url | grep @ | cut -d@ -f1)"
# remove password from url
tmp="@"
url="$(echo ${url/$password$tmp/})"
# extract the host
host="$(echo ${url/$user:$password@/} | cut -d/ -f1)"
# extract the database (if any)
path="$(echo $url | grep / | cut -d/ -f2-)"
database="$(echo $path | grep ? | cut -d? -f1)"


php -f magento/install.php -- --license_agreement_accepted yes \
  --locale en_US --timezone "America/Los_Angeles" --default_currency USD \
  --db_host $host --db_name $database --db_user magentouser --db_pass password \
  --url "https://magento-poc-06daee430b6f.herokuapp.com/" --use_rewrites yes \
  --use_secure no --secure_base_url "https://magento-poc-06daee430b6f.herokuapp.com/" --use_secure_admin no \
  --skip_url_validation yes \
  --admin_lastname Owner --admin_firstname Store --admin_email "admin@example.com" \
  --admin_username admin --admin_password password123
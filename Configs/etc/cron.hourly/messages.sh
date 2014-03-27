#!/bin/bash
lockfile -r 0 /tmp/the.lock || exit 1
php /var/www/html/alltutors.ru/public/cron/messages.php > /var/log/alltutors.ru/result
date >> /var/log/alltutors.ru/messages
cat /var/log/alltutors.ru/result >> /var/log/alltutors.ru/messages
rm -f /tmp/the.lock
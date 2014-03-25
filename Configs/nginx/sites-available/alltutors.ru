server {
    listen       80;
    server_name  www.alltutors.ru;
    return       301 http://alltutors.ru$request_uri;
}

server {
    if ( $http_user_agent ~* (nmap|nikto|wikto|sf|sqlmap|bsqlbf|w3af|acunetix|havij|appscan) ) {
        return 403;
    }
    #add_header X-Frame-Options DENY;
    add_header X-Content-Type-Options nosniff;
    add_header X-XSS-Protection "1; mode=block;";
    listen       80;
    server_name  alltutors.ru;
    access_log /var/log/alltutors.ru/nginx.access_log;
    root /var/www/html/alltutors.ru/public;
    index index.html index.php;

    location ~ /\.ht {
        deny all;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    include /etc/nginx/conf.d/caches.conf;

    location ~ \.php?$ {
        try_files $uri @missing;
        include fastcgi_params;
        #fastcgi_pass 127.0.0.1:9001;
        fastcgi_pass unix:/var/run/php-main.socket;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_intercept_errors on;
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        #Prevent version info leakage
        fastcgi_hide_header X-Powered-By;
    }
    location @missing {
        error_page 404 /page/404;
    }
}
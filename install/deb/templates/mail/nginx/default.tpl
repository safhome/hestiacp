server {
    listen      %ip%:%proxy_port%;
    server_name %domain_idn% %alias_idn%;
    root        /var/lib/roundcube;
    index       index.php index.html index.htm;
    access_log /var/log/nginx/domains/%domain%.log combined;
    error_log  /var/log/nginx/domains/%domain%.error.log error;

    include %home%/%user%/conf/mail/%root_domain%/nginx.forcessl.conf*;

    location ~ /\.(?!well-known\/) {
        deny all;
        return 404;
    }

    location ~ ^/(README.md|config|temp|logs|bin|SQL|INSTALL|LICENSE|CHANGELOG|UPGRADING)$ {
        deny all;
        return 404;
    }

    location / {
        proxy_pass http://%ip%:%web_port%;
        try_files $uri $uri/ =404;
        alias /var/lib/roundcube/;
        location ~* ^.+\.(ogg|ogv|svg|svgz|swf|eot|otf|woff|woff2|mov|mp3|mp4|webm|flv|ttf|rss|atom|jpg|jpeg|gif|png|webp|ico|bmp|mid|midi|wav|rtf|css|js|jar)$ {
            expires 7d;
            fastcgi_hide_header "Set-Cookie";
        }
    }

    location /error/ {
        alias /var/www/document_errors/;
    }

    location @fallback {
        proxy_pass http://%ip%:%web_port%;
    }

    include %home%/%user%/conf/mail/%root_domain%/%proxy_system%.conf_*;
}

<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);
$htaccess = <<<EOT
# BEGIN Gzip Compression
<ifmodule mod_rewrite.c>
     AddEncoding gzip .gz
     <filesmatch "\.js\.gz$">
        AddType "text/javascript" .gz
     </filesmatch>
     <filesmatch "\.css\.gz$">
        AddType "text/css" .gz
     </filesmatch>
</ifmodule>

AddType font/ttf .ttf
AddType font/otf .otf
AddType application/font-woff .woff
AddType application/vnd.ms-fontobject .eot

<ifmodule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css application/x-javascript application/javascript text/javascript
</ifmodule>
# END Gzip Compression

# Force mime for javascript files
<Files "*.js">
    ForceType text/javascript
</Files>

# BEGIN Caching
<ifModule mod_expires.c>
    ExpiresActive On
    ExpiresDefault A300

    ExpiresByType image/x-icon A2592000

    <FilesMatch ".(php)$">
        ExpiresDefault A0
        Header set Cache-Control "no-store, no-cache, must-revalidate, max-age=0"
        Header set Pragma "no-cache"
    </FilesMatch>
</ifModule>
# END Caching

# BEGIN Spelling
<IfModule mod_speling.c>
    CheckSpelling On
    CheckCaseOnly On
</IfModule>
# END Spelling

# BEGIN URL rewrite
<ifmodule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{HTTP:Accept-encoding} gzip
    RewriteCond %{REQUEST_FILENAME} \.(js|css)$
    RewriteCond %{REQUEST_FILENAME}.gz -f
    RewriteRule ^(.*)$ $1.gz [QSA,L]

EOT;

if (\stripos($fullTLD, '127.0.0.1') === false) {
    if (\filter_var($fullTLD, \FILTER_VALIDATE_IP) === false) {
$htaccess .= <<<EOT
    RewriteCond %{HTTP_HOST} !^www.*$ [L]

EOT;
    }

$htaccess .= <<<EOT
    RewriteCond %{HTTP_HOST} ^(.*)\.{$tld}
    RewriteRule ^([a-zA-Z]{2})\/(.*)$ {$fullTLD}/$1/%1/$2 [QSA]

EOT;
}

$htaccess .= <<<EOT
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$
EOT;

$htaccess .= ' ' . $subPath;

$htaccess .= <<<EOT
?{QUERY_STRING} [QSA]

EOT;

return $htaccess . <<< EOT
    RewriteCond %{HTTPS} !on
    RewriteCond %{HTTP_HOST} !^(127\.0\.0)|(192\.)|(172\.)
    RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI}
</ifmodule>
# END URL rewrite

# BEGIN Access control
<FilesMatch "\.(php|pdf|log)$">
    Order Deny,Allow
    Deny from all
    Allow from 127.0.0.1
</FilesMatch>
<Files index.php>
    Allow from all
</Files>
# END Access control

# Disable directory view
Options All -Indexes

# Disable unsupported scripts
Options -ExecCGI
AddHandler cgi-script .pl .py .jsp .asp .shtml .sh .cgi

#<ifmodule mod_headers.c>
#    # XSS protection
#    header always set x-xss-protection "1; mode=block"
#
#    # Nosnif
#    header always set x-content-type-options "nosniff"
#
#    # Iframes only from self
#    header always set x-frame-options "SAMEORIGIN"
#</ifmodule>

<ifmodule mod_headers.c>
    <FilesMatch "ServiceWorker.js$">
        Header set Service-Worker-Allowed "/"
    </FilesMatch>
</ifmodule>

# Env variables
# Stripe
SetEnv OMS_STRIPE_SECRET sk_live_
SetEnv OMS_STRIPE_PUBLIC pk_live_
SetEnv OMS_STRIPE_WEBHOOK we_

#Paypal

# Jingga
SetEnv OMS_PRIVATE_KEY_I {$private_key_i}

# Php config
# This should be removed from here and adjusted in the php.ini file
php_value upload_max_filesize 40M
php_value post_max_size 40M
php_value memory_limit 128M
php_value max_input_time 30
php_value max_execution_time 30
EOT;

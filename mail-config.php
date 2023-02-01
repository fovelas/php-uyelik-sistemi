<?php

return array(
    // sistemin mail atabilmesi için önemlidir
    // daha detaylı ayar yapmak için 'signup.php' dosyasındaki 'sendMail()' fonksiyonuna göz atın
    "base_url" => "http://localhost/php-uyelik-sistemi/", // 'index.php' bulunduğu klasör (gerekli)
    "host" => "smtp.example.com", // SMTP sunucusu
    "username" => "user@example.com", // SMTP kullanıcı adı
    "password" => "secret", // SMTP şifre
    "port" => "465" // SMTP port
);

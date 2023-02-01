# PHP MYSQL Basit Üyelik Sistemi
PHP ve MYSQL kullanılarak yazılmış basit bir üyelik sistemi. Projeye eklenen yeni özellikler:

- Kullanıcılar kayıt olduğunda mailini doğrulaması gerekir.
- Şifre sıfırlama sayfası.

-----------------------------------------

### Dokümantasyon
- [Veritabanı Kurulum](#veritabanı-kurulum)
- [Mail Ayarları](#mail-ayarları)
- [Ekran Görüntüleri](#ekran-görüntüleri)
- [Demo Sayfası](#demo-sayfası)

-----------------------------------------

### Veritabanı Kurulum
Veritabanı oluşturun. `utf8_general_ci` seçili olmasına dikkat edin.

![](https://img001.prntscr.com/file/img001/ExkEhbzqTzKxXC0kOR1USA.png)

`db` klasörü içerisindeki `db.sql` dosyasını phpMyAdmin'de oluşturduğunuz veritabanı içerisine `import` edin.

![](https://img001.prntscr.com/file/img001/0_8nuCeIQEmQ-gybVd9HkA.png)

![](https://img001.prntscr.com/file/img001/sCCdaOyaTfC3GNKEQ4SMtQ.png)

Son olarak `database.php` dosyasındaki alanları oluşturduğunuz veritabanına göre değiştirin.

-----------------------------------------

### Mail Ayarları
Kullanıcılar kayıt olabilmesi için hesaplarını doğrulaması gerekmektedir. Kullanıcının mailine doğrulama linkini gönderebilmek için `mail-config.php` dosyasındaki alanları kendi SMTP sunucunuza göre değiştirin.

Doğrulama mail örneği:

![](https://img001.prntscr.com/file/img001/E7CMnDLtRbWNRL7qPERGCQ.png)

-----------------------------------------

### Ekran Görüntüleri
![](https://img001.prntscr.com/file/img001/IKQ_z71CQWq-TQObMVhRzg.png)

![](https://img001.prntscr.com/file/img001/xOSDWcYDTeiekTxhrkab-Q.png)

![](https://img001.prntscr.com/file/img001/9JhhIvn-SWy5AJPDnNU4pw.png)

![](https://img001.prntscr.com/file/img001/RFBsQstKQzyDhtSDhGGvHw.png)

![](https://img001.prntscr.com/file/img001/OzqfY7IQS5yqfyPrIPgFHw.png)

-----------------------------------------

### Demo Sayfası
Aşağıdaki bilgilerle demo sitesine giderek deneyebilirsiniz.

**Link:** https://hankagan.com/php-uyelik-sistemi/</br>
**Email:** admin@mail.com</br>
**Şifre:** 12345

-----------------------------------------

### Uyarı
Bu sistem birçok güvenlik açığı bulunan başlangıç seviye bir projedir. Sizlere örnek olması amacıyla yazılmıştır.

<b><a href="https://hknsoft.com/">hknsoft</a></b> &copy; 2020-2023
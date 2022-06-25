# crealive-case-study

## Kurulum Aşamasında Yapılması Gerekenler:
1. "ccs" isminde veritabanı oluşturulması.
2. Veritabanında "settings" tablosundaki "url" sütununu kendi localhost'ınızda yükleyeceğiniz yer ile değiştirilmesi.
		örnek: http://localhost/mehmetozgul/crealive-case-study şeklinde olan şu anki site adresi. Benim sitem http://localhost/mehmetozgul adresinde yüklü.
3. assets/js/main.js dosyasındaki SITE_URL değişkenine, "settings" tablosundaki "url" sütununa girdiğiniz değeri yazınız.


4. $MYSQL_HOST = 'localhost';
		
    $MYSQL_USER = 'root';
		
    $MYSQL_PASS = '';
    
    $MYSQL_DB = 'ccs'; 
		
    MySQL ayarları bu şekildedir değiştirmek isterseniz. classes/db/database.class.php dosyasındaki değerleri değiştirebilirsiniz.
    
5. Panel e-posta adresi: test@test.com şifre: 123456

## Kısaca Yaptıklarımdan Bahsedeyim
Öncelikle, hazır tek sayfalık blog teması buldum. Sonra bootstrap bilgimi kullanarak bunu düzenledim ve kendi projeme göre uygun sayfalar 		oluşturdum. Daha sonra admin panelini yazmaya başladım. Bunun için gerekli olan MYSQL veritabanı ve tablolar oluşturdum. Admin girişi için basit bir sayfa hazırladım. Girilen bilgileri AJAX işlemi ile başka bir php dosyasında kontrollerden geçirdim. Veritabanımdaki admin bilgileriyle karşılaştırdım ve doğru kişiyse panele girişini sağladım. Panelde blog ekleme, güncelleme ve silme alanlarını, basit form işlemleri oluşturdum. Yine AJAX işlemi ile ekleme, güncelleme, silme gibi işlemleri gerçekleştirdim.
Kullanıcı siteyi açtığında bütün kategorileri tek seferde görüyor olacak. Sağ üstten kategoriler kısmından kategori seçerek bloglara filtremele işlemi yapabiliyor olacak.

## Kullandığım Araçlar:
### HTML5, CSS3, Bootstrap5, PHP, JQUERY AJAX, sweetalert2

# PHP Görevi – Dosya Transferi (Senaryo 1)

Bu proje, PHP ile dosya yükleme, listeleme, detay görüntüleme, indirme ve silme işlemlerini sunan küçük bir REST servisidir.


## Teknolojiler

- PHP 8+
- MySQL


## Proje Mimarisi

### Environment

- Veritabanı bağlantı bilgileri `.env.example` dosyasında tanımlıdır.
  - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`

### Controllers

- `Controllers/FileController`
  - HTTP isteklerini karşılar, giriş doğrulamalarını yapar ve yanıtları JSON formatında döner.
  - Yükleme, listeleme, detay, silme ve indirme uçlarını servis katmanına yönlendirir.

### Services

- `Services/FileServices`
  - İş kurallarını uygular: dosya boyutu ve MIME kontrolü, izin verilen uzantılar, checksum üretimi ve upload klasörüne güvenli kaydetme.
  - Veritabanı işlemleri için repository katmanını kullanır ve indirme için dosya yolunu hazırlar.

### Repositories

- `Repositories/FileRepository`
  - MySQL üzerinde CRUD işlemlerini yürütür.
  - Listeleme, detay sorguları ve soft delete işlemlerini gerçekleştirir.

### Connection

- `Connection/Database.php`
  - PDO ile veritabanı bağlantısını kurar ve paylaşır.


## API Özeti

- `POST /api/files` – Dosya yükle (isteğe bağlı açıklama ile)
- `GET /api/files` – Sayfalı dosya listesi (`page`, `pageSize` varsayılan: 1, 10)
- `GET /api/files/{id}` – Dosya detayı
- `GET /api/files/{id}/download` – Dosyayı indir
- `DELETE /api/files/{id}` – Dosyayı sil


## Kurulum ve Çalıştırma

1) `.env.example` dosyasını `.env` olarak kopyalayın ve veritabanı bilgilerini doldurun:
   ```
   DB_HOST=
   DB_NAME=
   DB_USER=
   DB_PASS=
   ```
2) Veritabanında `files` tablosunu oluşturun.(Veritabanı sql/file_system_db).
3) Uygulamayı başlatın:
   ```
   php -S localhost:8000 -t public
   ```
4) API artık `http://localhost:8000` adresinden ulaşılabilir.


## Notlar

- Upload edilen dosyalar `public/uploads` dizininde tutulur.
- Maksimum dosya boyutu 10MB; izin verilen uzantılar: `pdf`, `jpg`, `png`, `txt`.

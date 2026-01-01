# Laravel Görevi – Endpoint Data → JSON Aktarım (Senaryo 4)

Laravel ile ürün işlemlerini sağlayan ve veriyi JSON dosyasına export edebilen bir API.


## Teknolojiler

- PHP 8+
- Laravel
- MySQL


## Proje Mimarisi

### Environment

- `.env` içinde veritabanı bilgileri (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) tanımlanır.
- Seeder’lar örnek ürün datası yükler (`php artisan db:seed`).

### Routes & Controllers

- `routes/api.php` → `/products` CRUD ve `/products/export` uçları.
- `App\Http\Controllers\ProductController`
  - Listeleme, detay, oluşturma, güncelleme ve export işlemlerini yönetir.

### Requests & Resources

- `App\Http\Requests\ProductRequest` → ürün giriş validasyonu.
- `App\Http\Resources\ProductResource` → API yanıtlarını normalize eder.

### Services

- `App\Services\ProductServices`
  - Listeleme ve detay sorguları.
  - Yeni kayıt validasyonları (zorunlu alanlar, `sale_price` > `list_price` kontrolü).
  - Güncelleme ve JSON export işlemleri.

### Models & Database

- `App\Models\Product` → `products` tablosu.
- `database/migrations/*create_products_table.php` → tablo şeması.
- `database/seeders/ProductSeeder` → örnek 20 ürün.


## API Uçları

- `GET /api/products?is_active=1&on_sale=1&limit=10` → paginated liste.
- `GET /api/products/{id}` → ürün detayı.
- `POST /api/products/new` → yeni ürün oluştur.
- `PUT /api/products/{id}` → ürün güncelle.
- `GET /api/products/export` → tüm ürünleri JSON’a aktarır, dosya yolu ve kayıt sayısı döner.

---

## Örnek İstekler

Listeleme:
```bash
curl "http://localhost:8000/api/products?is_active=1&on_sale=1&limit=5"
```

Yeni ürün:
```bash
curl -X POST "http://localhost:8000/api/products/new" \
  -H "Content-Type: application/json" \
  -d '{
    "is_active": true,
    "name": "Mini Hoparlör",
    "description": "Bluetooth, 10W, IPX4",
    "barcode": "8690000000021",
    "warranty_period": 24,
    "list_price": 799.90,
    "sale_price": 699.90,
    "quantity": 30,
    "on_sale": true
  }'
```

Export:
```bash
curl "http://localhost:8000/api/products/export"
```

---

## Kurulum

1) `.env.example` dosyasını `.env` olarak kopyalayın ve veritabanı bilgilerini girin.
2) Bağımlılıkları yükleyin:
   ```bash
   composer install
   ```
3) Migration ve seeder çalıştırın:
   ```bash
   php artisan migrate --seed
   ```
4) Uygulamayı başlatın:
   ```bash
   php artisan serve
   ```
5) API: `http://localhost:8000/api/*`


## Notlar

- Export çıktısı `storage/app/exports/products_YYYYMMDD_HHMM.json` altında oluşturulur.
- `sale_price` değerinin `list_price`’dan büyük olması engellenir; zorunlu alanlar olmadan kayıt oluşturulmaz.
- Postman istekleri örnekleri için `postman/` klasörüne bakabilirsiniz.

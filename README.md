# TipVerify

Platforma pre verifikáciu tipsterských tipov. Tipstri zverejňujú tipy, admin verifikuje výsledky, systém sleduje ROI a úspešnosť.

## Technológie

- **Laravel 11** — PHP framework
- **SQLite** — databáza (lokálne), MySQL (produkcia)
- **Laravel Breeze** — autentifikácia
- **Tailwind CSS** — dizajn
- **Pest** — testy

## Funkcie

- Registrácia a prihlásenie tipstrov
- Pridávanie tipov s kurzom a dátumom
- Verejné profily tipstrov s ROI štatistikami
- Admin panel — verifikácia výsledkov (win/loss)
- REST API — `/api/tips`, `/api/tipsters/{id}/stats`
- 36 automatizovaných testov

## Inštalácia

```bash
git clone https://github.com/666vaci666/tipverify.git
cd tipverify
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## API

| Endpoint | Metóda | Popis |
|----------|--------|-------|
| `/api/tips` | GET | Zoznam všetkých tipov |
| `/api/tipsters/{id}/stats` | GET | Štatistiky tipstra |

## Testy

```bash
php artisan test
```
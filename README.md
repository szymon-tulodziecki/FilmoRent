# Aplikacje Internetowe I 

**Autor:** Szymon Tułodziecki  
**Nr albumu:** 21312

---

## FilmoRent

Aplikacja internetowa umożliwiająca wypożyczanie profesjonalnego sprzętu filmowego. System pozwala użytkownikom na przeglądanie dostępnego wyposażenia, składanie rezerwacji oraz zarządzanie wypożyczeniami w intuicyjny i efektywny sposób.

## Wymagania Projektu

### 1. Struktura Bazy Danych
- **Minimum 9 tabel** (w tym tabele generowane automatycznie przez Laravel)
- Migracje zapewniające kompatybilność z różnymi systemami zarządzania bazą danych
- Seedery generujące przykładowe dane dla wszystkich tabel

### 2. System Uprawnień
Aplikacja rozróżnia trzy poziomy użytkowników:
- **Administrator** - pełny dostęp do wszystkich funkcji systemu
- **Pracownik** - dostęp do panelu zarządzania wypożyczeniami i obsługi zamówień klientów
- **Klient** - dostęp do przeglądania sprzętu, składania rezerwacji i zarządzania własnymi wypożyczeniami

### 3. Architektura Aplikacji
- **Frontend** - panel dla klientów z intuicyjnym interfejsem użytkownika
- **Backend** - panel administracyjny dla pracowników i administratorów

### 4. Dostępność (WCAG)
Aplikacja została zaprojektowana z myślą o osobach niepełnosprawnych:
- Wsparcie dla czytników ekranu
- Nawigacja klawiaturą
- Odpowiedni kontrast kolorów
- Opisowe etykiety i atrybuty ARIA
- Responsywny design

### 5. Kontrola Wersji
Projekt zarządzany przy użyciu systemu **Git** z regularnym commitowaniem zmian.

### 6. Testy Jednostkowe
Aplikacja zawiera **minimum 5 testów jednostkowych** weryfikujących poprawność działania kluczowych funkcjonalności.

## Technologie

- **Framework:** Laravel 11 + Filament 3
- **Baza danych:** Zgodna z różnymi systemami (MySQL, PostgreSQL, SQLite)
- **Frontend:** Tailwind CSS + Livewire
- **Kontrola wersji:** Git
- **Testy:** PHPUnit

```bash
cd aplikacja
composer install
npm install
php artisan migrate
php artisan db:seed
php artisan serve
```

Panel administracyjny: **http://localhost:8000/admin**

---

## Testy Jednostkowe

Aplikacja zawiera testy jednostkowe dla modelu `Sprzet`, weryfikujące poprawność kluczowych funkcjonalności. Testy znajdują się w pliku `tests/Unit/SprzedajTest.php`.

### Uruchamianie testów

```bash
php artisan test tests/Unit/SprzedajTest.php
```

### Dostępne testy:

1. **test_mozna_utworzyc_sprzet_z_prawidlowymi_danymi**
   - Sprawdza, czy można utworzyć nowy sprzęt z prawidłowymi danymi
   - Weryfikuje poprawne zapisanie atrybutów w bazie danych

2. **test_czydostepny_zwraca_true_dla_dostepnego_sprzetu**
   - Testuje metodę `czyDostepny()`
   - Weryfikuje zwrócenie wartości `true` dla sprzętu ze statusem 'dostepny'

3. **test_czydostepny_zwraca_false_dla_niedostepnego_sprzetu**
   - Testuje metodę `czyDostepny()`
   - Weryfikuje zwrócenie wartości `false` dla sprzętu w innym statusie

4. **test_sprzet_ma_prawidlowe_relacje**
   - Sprawdza relacje Eloquent modelu `Sprzet`
   - Weryfikuje prawidłowe powiązanie z modelami `Kategoria` i `Producent`

5. **test_get_zdjecie_url_zwraca_prawidlowy_url**
   - Testuje metodę `getZdjecieUrl()`
   - Sprawdza zwrócenie custom URL jeśli jest ustawiony
   - Weryfikuje zwrócenie domyślnego URL na podstawie kategorii

---

## Diagram relacji bazy danych

![Database Schema](img/baza_schemat.png)
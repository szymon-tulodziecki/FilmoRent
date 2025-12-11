# Aplikacje Internetowe I 

**Autor:** Szymon Tułodzieckie  
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

- **Framework:** Laravel
- **Baza danych:** Zgodna z różnymi systemami (MySQL, PostgreSQL, SQLite)
- **Frontend:** Tailwind CSS
- **Kontrola wersji:** Git
- **Testy:** PHPUnit
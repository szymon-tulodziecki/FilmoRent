<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmoRent - Test bazy danych</title>
</head>
<body>
    <h1>FilmoRent - Test bazy danych</h1>

    <h2>Statystyki</h2>
    <ul>
        @foreach($statystyki as $nazwa => $wartosc)
        <li><strong>{{ ucfirst(str_replace('_', ' ', $nazwa)) }}:</strong> {{ $wartosc }}</li>
        @endforeach
    </ul>

    <h2>Role i użytkownicy</h2>
    @foreach($role as $rola)
        <h3>{{ $rola->nazwa }} ({{ $rola->klucz }})</h3>
        <ul>
            @forelse($rola->uzytkownicy as $u)
                <li>{{ $u->imie }} {{ $u->nazwisko }} &lt;{{ $u->email }}&gt;</li>
            @empty
                <li><em>Brak użytkowników</em></li>
            @endforelse
        </ul>
    @endforeach

    <h2>Kategorie</h2>
    <ul>
        @foreach($kategorie as $kat)
            <li>
                <strong>{{ $kat->nazwa }}</strong>
                @if($kat->dzieci->count())
                <ul>
                    @foreach($kat->dzieci as $dziecko)
                        <li>{{ $dziecko->nazwa }}</li>
                    @endforeach
                </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <h2>Sprzęt ({{ $sprzet->count() }} pozycji)</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nazwa</th>
            <th>Producent</th>
            <th>Kategoria</th>
            <th>Nr seryjny</th>
            <th>Cena/doba</th>
            <th>Kaucja</th>
            <th>Status</th>
        </tr>
        @foreach($sprzet as $s)
        <tr>
            <td>{{ $s->nazwa }}</td>
            <td>{{ $s->producent->nazwa }}</td>
            <td>{{ $s->kategoria->nazwa }}</td>
            <td>{{ $s->numer_seryjny }}</td>
            <td>{{ number_format($s->cena_doba, 2, ',', ' ') }} zł</td>
            <td>{{ number_format($s->kaucja, 2, ',', ' ') }} zł</td>
            <td>{{ $s->status_sprzetu }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Wypożyczenia</h2>
    @forelse($wypozyczenia as $w)
        <h3>{{ $w->numer_zamowienia }}</h3>
        <p>
            <strong>Klient:</strong> {{ $w->uzytkownik->imie }} {{ $w->uzytkownik->nazwisko }}<br>
            <strong>Pracownik:</strong> {{ $w->pracownik?->imie }} {{ $w->pracownik?->nazwisko }}<br>
            <strong>Status:</strong> {{ $w->status->nazwa }}<br>
            <strong>Okres:</strong> {{ $w->data_odbioru?->format('d.m.Y') }} – {{ $w->data_zwrotu?->format('d.m.Y') }}<br>
            <strong>Suma:</strong> {{ number_format($w->suma_calkowita, 2, ',', ' ') }} zł
        </p>
        <p><strong>Wypożyczony sprzęt:</strong></p>
        <ul>
            @foreach($w->sprzety as $s)
                <li>{{ $s->nazwa }} – {{ number_format($s->pivot->cena_netto_snapshot, 2, ',', ' ') }} zł/doba
                    @if($s->pivot->rabat_procent > 0) (rabat {{ $s->pivot->rabat_procent }}%) @endif
                </li>
            @endforeach
        </ul>
        <p><strong>Płatności:</strong></p>
        <ul>
            @foreach($w->platnosci as $p)
                <li>{{ ucfirst($p->typ) }} – {{ number_format($p->kwota, 2, ',', ' ') }} zł ({{ $p->metoda }}, {{ $p->status }})</li>
            @endforeach
        </ul>
        @if($w->uwagi)
        <p><strong>Uwagi:</strong> {{ $w->uwagi }}</p>
        @endif
        <hr>
    @empty
        <p><em>Brak wypożyczeń</em></p>
    @endforelse

    <footer>
        <p>FilmoRent &copy; {{ date('Y') }}</p>
    </footer>
</body>
</html>

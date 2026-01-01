<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Koszyk - FilmoRent. Zarządzaj swoimi rezerwacjami sprzętu filmowego">
    <title>Koszyk - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <x-styles />
</head>
<body class="bg-slate-950 text-slate-100 antialiased font-['Manrope']">
@php
    use Carbon\Carbon;
    $pozycje = $koszyk ?? session('koszyk', []);
    $suma = $suma ?? collect($pozycje)->sum('cena_calkowita');
    $kaucjaSuma = $kaucjaSuma ?? collect($pozycje)->sum('kaucja');
    $lacznieDni = collect($pozycje)->sum('dni');
@endphp

    <x-navbar />

    <main class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <p class="text-sm uppercase tracking-[0.15em] text-amber-400 font-bold mb-2">Twoja rezerwacja</p>
                    <h1 class="text-3xl sm:text-4xl font-black text-white">Koszyk</h1>
                </div>
                <a href="{{ route('sklep') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-amber-400 text-sm font-semibold">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Wróć do sklepu
                </a>
            </div>

            @if(empty($pozycje))
                <div class="text-center py-20">
                    <div class="bg-slate-900/95 rounded-2xl border border-slate-600 p-12 max-w-md mx-auto shadow-xl">
                        <div class="bg-slate-800/90 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6 border border-slate-600">
                            <i data-lucide="shopping-cart" class="w-12 h-12 text-slate-200"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-4">Twój koszyk jest pusty</h2>
                        <p class="text-slate-200 mb-8 leading-relaxed">
                            Nie masz jeszcze żadnych produktów w koszyku. Przejdź do sklepu i dodaj sprzęt do wypożyczenia.
                        </p>
                        <a href="{{ route('sklep') }}" class="px-8 py-4 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl shadow-lg inline-flex items-center gap-2 transition">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            Przejdź do sklepu
                        </a>
                    </div>
                </div>
            @else
                <div class="grid lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-8 space-y-6">
                        @foreach($pozycje as $index => $item)
                            @php
                                $cenaDoba = $item['cena_doba'] ?? $item['cena_za_dzien'] ?? 0;
                                $start = Carbon::parse($item['data_od']);
                                $end = Carbon::parse($item['data_do']);
                            @endphp
                            <div class="bg-slate-900/95 rounded-2xl border border-slate-600 p-5 sm:p-6 shadow-xl">
                                <div class="flex gap-5 sm:gap-6 items-start">
                                    <div class="w-28 h-28 sm:w-32 sm:h-32 bg-slate-800/90 border border-slate-600 rounded-xl overflow-hidden flex-shrink-0">
                                        <img src="{{ $item['zdjecie'] ?? '' }}" alt="{{ $item['nazwa'] }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 space-y-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="text-xs uppercase tracking-[0.12em] text-slate-300 font-semibold mb-1">{{ $item['kategoria'] ?? 'Sprzęt' }}</p>
                                                <h2 class="text-lg sm:text-xl font-bold text-white leading-tight">{{ $item['nazwa'] }}</h2>
                                                <p class="text-sm text-slate-200">{{ $item['producent'] ?? 'Producent' }}</p>
                                            </div>
                                            <form action="{{ route('koszyk.usun', $index) }}" method="POST" class="flex-shrink-0">
                                                @csrf
                                                <button type="submit" class="text-slate-300 hover:text-red-400 transition" title="Usuń z koszyka">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm text-slate-100">
                                            <div class="bg-slate-800/90 border border-slate-600 rounded-xl p-3">
                                                <p class="text-[11px] uppercase tracking-[0.08em] text-slate-300 mb-1">Od</p>
                                                <p class="font-semibold">{{ $start->format('d.m.Y') }}</p>
                                            </div>
                                            <div class="bg-slate-800/90 border border-slate-600 rounded-xl p-3">
                                                <p class="text-[11px] uppercase tracking-[0.08em] text-slate-300 mb-1">Do</p>
                                                <p class="font-semibold">{{ $end->format('d.m.Y') }}</p>
                                            </div>
                                            <div class="bg-slate-800/90 border border-slate-600 rounded-xl p-3">
                                                <p class="text-[11px] uppercase tracking-[0.08em] text-slate-300 mb-1">Liczba dni</p>
                                                <p class="font-semibold">{{ $item['dni'] }}</p>
                                            </div>
                                            <div class="bg-slate-800/90 border border-slate-600 rounded-xl p-3">
                                                <p class="text-[11px] uppercase tracking-[0.08em] text-slate-300 mb-1">Cena / doba</p>
                                                <p class="font-semibold">{{ number_format($cenaDoba, 0, ',', ' ') }} zł</p>
                                            </div>
                                        </div>

                                        <div class="pt-3 border-t border-slate-700">
                                            <button type="button" onclick="toggleEdit({{ $index }})" class="text-xs text-amber-400 hover:text-amber-300 transition flex items-center gap-1 font-semibold">
                                                <i data-lucide="edit-2" class="w-3 h-3"></i>
                                                Zmień daty
                                            </button>
                                            <div id="edit-form-{{ $index }}" class="mt-3 hidden space-y-3 p-3 bg-slate-800/50 rounded-lg border border-slate-700">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="text-xs text-slate-400">Od</label>
                                                        <input type="date" id="data_od_{{ $index }}" value="{{ $start->format('Y-m-d') }}" class="w-full px-2 py-1 bg-slate-900 border border-slate-600 rounded text-slate-100 text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="text-xs text-slate-400">Do</label>
                                                        <input type="date" id="data_do_{{ $index }}" value="{{ $end->format('Y-m-d') }}" class="w-full px-2 py-1 bg-slate-900 border border-slate-600 rounded text-slate-100 text-sm">
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button" onclick="updateDate({{ $index }})" class="flex-1 px-2 py-2 bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 text-xs font-semibold rounded transition">
                                                        Zatwierdź
                                                    </button>
                                                    <button type="button" onclick="toggleEdit({{ $index }})" class="flex-1 px-2 py-2 bg-slate-700/50 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded transition">
                                                        Anuluj
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between pt-2">
                                            <div class="text-xs text-slate-300">Kaucja: <span class="text-white font-semibold">{{ number_format($item['kaucja'] ?? 0, 0, ',', ' ') }} zł</span></div>
                                            <div class="text-right">
                                                <p class="text-xs text-slate-300">Suma</p>
                                                <p class="text-2xl font-black text-amber-400">{{ number_format($item['cena_calkowita'], 0, ',', ' ') }} zł</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="lg:col-span-4 space-y-4">
                        <div class="bg-slate-900/95 rounded-2xl border border-slate-600 p-6 shadow-xl">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-400/60 flex items-center justify-center">
                                    <i data-lucide="receipt" class="w-5 h-5 text-amber-400"></i>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-[0.12em] text-slate-300 font-semibold">Podsumowanie</p>
                                    <h3 class="text-lg font-bold text-white">Zamówienie</h3>
                                </div>
                            </div>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-slate-100">
                                    <span>Pozycje</span>
                                    <span>{{ count($pozycje) }} szt.</span>
                                </div>
                                <div class="flex justify-between text-slate-100">
                                    <span>Łącznie dni</span>
                                    <span>{{ $lacznieDni }}</span>
                                </div>
                                <div class="flex justify-between text-slate-100">
                                    <span>Kaucja łączna</span>
                                    <span>{{ number_format($kaucjaSuma, 0, ',', ' ') }} zł</span>
                                </div>
                                <hr class="border-slate-800">
                                <div class="flex justify-between items-center text-white font-bold text-xl">
                                    <span>Suma wypożyczenia</span>
                                    <span>{{ number_format($suma, 0, ',', ' ') }} zł</span>
                                </div>
                            </div>

                            <div class="mt-6 space-y-3">
                                <form action="{{ route('koszyk.zloz') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold py-4 rounded-xl shadow-lg shadow-amber-500/20 transition active:scale-95">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        Złóż zamówienie
                                    </button>
                                </form>
                                <p class="text-xs text-slate-500 text-center">Po złożeniu zamówienia zostaniesz przekierowany do panelu klienta.</p>
                            </div>
                        </div>

                        <div class="bg-slate-900/95 rounded-2xl border border-slate-600 p-6">
                            <h4 class="text-sm font-semibold text-white mb-3">Dlaczego warto?</h4>
                            <ul class="space-y-2 text-sm text-slate-100">
                                <li class="flex items-center gap-2"><i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i> Ubezpieczenie i wsparcie techniczne 24/7</li>
                                <li class="flex items-center gap-2"><i data-lucide="truck" class="w-4 h-4 text-green-400"></i> Dostawa i odbiór na terenie miasta</li>
                                <li class="flex items-center gap-2"><i data-lucide="clock-4" class="w-4 h-4 text-green-400"></i> Elastyczne przedłużenie rezerwacji</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <x-footer />

    <script>
        function toggleEdit(index) {
            const editForm = document.getElementById(`edit-form-${index}`);
            editForm?.classList.toggle('hidden');
        }

        function updateDate(index) {
            const dataOd = document.getElementById(`data_od_${index}`).value;
            const dataDo = document.getElementById(`data_do_${index}`).value;

            if (!dataOd || !dataDo) {
                alert('Uzupełnij obie daty');
                return;
            }

            const start = new Date(dataOd);
            const end = new Date(dataDo);

            if (start >= end) {
                alert('Data "Od" musi być wcześniejsza niż data "Do"');
                return;
            }

            // Wyślij AJAX request do aktualizacji dat w koszyku
            fetch('{{ route("koszyk.aktualizuj") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    index: index,
                    data_od: dataOd,
                    data_do: dataDo
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Przeładuj stronę aby wyświetlić nowe ceny
                    location.reload();
                } else {
                    alert(data.message || 'Błąd podczas aktualizacji dat');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Błąd podczas aktualizacji dat');
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
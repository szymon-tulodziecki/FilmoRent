@extends('layouts.front')

@section('title', $sprzet->nazwa . ' - FilmoRent')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex space-x-2 text-sm text-gray-500">
            <li><a href="/" class="hover:text-blue-700 focus:outline-none focus:underline">Strona główna</a></li>
            <li><span>/</span></li>
            <li><a href="/?wybranaKategoria={{ $sprzet->kategoria_id }}" class="hover:text-blue-700 focus:outline-none focus:underline">{{ $sprzet->kategoria->nazwa }}</a></li>
            <li><span>/</span></li>
            <li class="font-semibold text-gray-900" aria-current="page">{{ $sprzet->nazwa }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            
            <div class="bg-gray-100 p-8 flex items-center justify-center min-h-[400px]">
                <div class="text-center">
                    <span class="text-9xl block mb-4">📷</span>
                    <span class="text-gray-500">Zdjęcie poglądowe: {{ $sprzet->producent->nazwa }}</span>
                </div>
            </div>

            <div class="p-8 flex flex-col justify-center">
                <div class="mb-2">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                        Producent: {{ $sprzet->producent->nazwa }}
                    </span>
                    <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2 mb-2">
                        Kaucja: {{ number_format($sprzet->kaucja, 0) }} zł
                    </span>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-4">{{ $sprzet->nazwa }}</h1>

                <div class="prose max-w-none text-gray-600 mb-8">
                    <p>{{ $sprzet->opis }}</p>
                    <ul class="mt-4 space-y-2 list-disc list-inside">
                        <li>Numer seryjny: <span class="font-mono bg-gray-100 p-1 rounded">{{ $sprzet->numer_seryjny }}</span></li>
                        <li>Stan: <span class="text-green-600 font-bold">Sprawny, gotowy do pracy</span></li>
                    </ul>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mt-auto">
                    <div class="flex items-end justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Cena za dobę</p>
                            <p class="text-4xl font-bold text-gray-900">{{ number_format($sprzet->cena_doba, 0) }} <span class="text-xl">zł</span></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 text-right">Wartość rynkowa</p>
                            <p class="text-sm font-medium text-gray-900 text-right">{{ number_format($sprzet->wartosc_rynkowa, 0) }} zł</p>
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('rezerwacja.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="sprzet_id" value="{{ $sprzet->id }}">
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="data_od" class="block text-sm font-medium text-gray-700">Data od</label>
                                    <input type="date" name="data_od" id="data_od" min="{{ date('Y-m-d') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="data_do" class="block text-sm font-medium text-gray-700">Data do</label>
                                    <input type="date" name="data_do" id="data_do" min="{{ date('Y-m-d') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-700 text-white text-lg font-bold py-3 px-4 rounded-lg hover:bg-blue-800 transition focus:outline-none focus:ring-4 focus:ring-blue-300 flex justify-center items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Rezerwuj teraz
                            </button>
                        </form>
                    @else
                        <div class="text-center p-4 bg-gray-100 rounded border border-gray-300">
                            <p class="mb-2 text-gray-700">Zaloguj się, aby dokonać rezerwacji.</p>
                            <a href="{{ route('login') }}" class="text-blue-700 font-bold hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500 rounded p-1">Przejdź do logowania</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

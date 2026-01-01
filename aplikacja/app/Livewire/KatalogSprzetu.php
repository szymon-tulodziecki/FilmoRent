<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sprzet;
use App\Models\Kategoria;
use Illuminate\Database\Eloquent\Builder;

class KatalogSprzetu extends Component
{
    use WithPagination;

    public $wyszukiwarka = '';
    public $wybranaKategoria = '';
    public $sortowanie = 'popularnosc';

    // Resetowanie paginacji przy zmianie filtrów
    public function updatingWyszukiwarka() { $this->resetPage(); }
    public function updatingWybranaKategoria() { $this->resetPage(); }

    public function render()
    {
        $sprzety = Sprzet::query()
            ->with(['producent', 'kategoria'])
            ->where('status_sprzetu', 'dostepny') // Tylko dostępny sprzęt
            ->when($this->wyszukiwarka, function (Builder $query) {
                $query->where('nazwa', 'like', '%' . $this->wyszukiwarka . '%');
            })
            ->when($this->wybranaKategoria, function (Builder $query) {
                $query->where('kategoria_id', $this->wybranaKategoria);
            })
            ->when($this->sortowanie === 'cena_rosnaco', fn($q) => $q->orderBy('cena_doba', 'asc'))
            ->when($this->sortowanie === 'cena_malejaco', fn($q) => $q->orderBy('cena_doba', 'desc'))
            ->paginate(9);

        return view('livewire.katalog-sprzetu', [
            'sprzety' => $sprzety,
            'kategorie' => Kategoria::all(),
        ])->layout('layouts.front');
    }
}

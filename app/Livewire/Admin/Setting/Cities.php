<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\City;
use Livewire\WithPagination;

class Cities extends Component
{
    use WithPagination;
    public $search = '';	

    public function render()
    {
        $cities =City::with('state');

        if($this->search)
        {
            $cities=$cities->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhereHas('state', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          });
                });

        }
        $cities= $cities->paginate(10);
        return view('livewire.admin.setting.cities',[
            'cities' => $cities
        ]);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
}
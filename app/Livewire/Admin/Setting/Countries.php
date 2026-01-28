<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\Country;
use Livewire\WithPagination;

class Countries extends Component
{	
    use WithPagination;
    public $search = '';

    public function render()
    {
        $countries =Country::query();
        if($this->search)
        {
            $countries=$countries->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });

        }
        $countries = $countries->paginate(10);
        return view('livewire.admin.setting.countries',[
            'countries'=>$countries
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}

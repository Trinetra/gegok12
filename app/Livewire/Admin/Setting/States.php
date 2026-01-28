<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\State;
use Livewire\WithPagination;

class States extends Component
{	
    use WithPagination;

    public $search = '';

    public function render()
    {
        $states =State::with('country');
         if($this->search)
        {
            $states=$states->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhereHas('country', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          });
                });

        }
        $states =$states-> paginate(10);
        return view('livewire.admin.setting.states',[
            'states' => $states
        ]);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
}

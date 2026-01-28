<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\State;

class StateDetail extends Component
{	
	public $StateDetailId;

	public function mount($id)
	{
		$this->StateDetailId = $id;
	}

    public function render()
    {	
    	$stateDetail = State::where('id', $this->StateDetailId)->first();

        return view('livewire.admin.setting.state-detail',[
        	'stateDetail' => $stateDetail,
        ]);
    }
}

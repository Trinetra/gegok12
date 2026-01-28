<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\Plan;

class PlanDetail extends Component
{	
	public $planDetailId;

	public function mount($id)
	{
		$this->planDetailId = $id;
	}

    public function render()
    {	
    	$planDetail = Plan::where('id', $this->planDetailId)->first();

        return view('livewire.admin.setting.plan-detail',[
        	'planDetail' => $planDetail,
        ]);
    }
}

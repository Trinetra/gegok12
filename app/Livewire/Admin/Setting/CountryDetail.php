<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\Country;

class CountryDetail extends Component
{	
	public $countryDetailId;

	public function mount($id)
	{
		$this->countryDetailId = $id;
	}

    public function render()
    {	
    	$countryDetail = Country::where('id', $this->countryDetailId)->first();
    	//dd($countryDetail);
    	
        return view('livewire.admin.setting.country-detail',[
        	'countryDetail' => $countryDetail,
        ]);
    }
}

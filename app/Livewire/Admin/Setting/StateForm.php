<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\Country;
use App\Models\State;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class StateForm extends Component
{	
	use LivewireAlert;

	#[Rule('required')]
	public $country;

	#[Rule('required')]
	public $name;

	#[Rule('required')]
	public $status;

	public $stateEditId;

	public function mount($id)
	{
		$this->stateEditId = $id;

		$stateEdit = State::where('id', $this->stateEditId)->first();
		$this->country = $stateEdit->country_id;
		$this->name = $stateEdit->name;
		$this->status = $stateEdit->status;
	}

	public function submitState()
	{	
		$this->validate();
		
		$data = [
			'country_id' => $this->country,
			'name' => $this->name,
			'status' => $this->status,
		];
        
        if($this->stateEditId!=null)
        {
        	State::where('id', $this->stateEditId)->update($data);
        	$this->alert('success', 'State updated successfully');
        } 
        else
        {
        	State::create($data);
        	$this->alert('success', 'State created successfully');
        }
		

		//session()->flash('message', 'State updated successfully');

		

		return redirect(url('/admin/setting/states'));
	}

    public function render()
    {	
    	$countries = Country::get();

        return view('livewire.admin.setting.state-form',[
        	'countries' => $countries,
        ]);
    }
}

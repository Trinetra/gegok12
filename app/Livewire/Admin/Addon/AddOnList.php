<?php

namespace App\Livewire\Admin\Addon;

use Livewire\Component;
use App\Traits\HandlesGuzzleRequests;
use GuzzleHttp\Client;
use Exception;
use Log;

class AddOnList extends Component
{
    use HandlesGuzzleRequests;

    public $addon;
    public $currentPage=1;

    public function mount()
    {
        $this->addon = $this->getAddons($this->currentPage);

    }
    public function render()
    {
          
        return view('livewire.admin.addon.add-on-list',[
            'addonsList' => $this->addon['data'],
            'pagination' => [
                'meta' => $this->addon['meta'] ?? [],
                'links' => $this->addon['links'] ?? [],
            ]
        ]);
    }

    public function getAddons($page)
    {

        $api_url = env('ADDON_API_URL') . '/api/addons';

        try {
            // dd('hii');

            $response = $this->guzzleGet($api_url, [
                'email' => auth()->user()->email,
                'domain_name' => request()->getHost(),
                'page' => $page,
            ]);

            return $response;

        } catch (Exception $e) 
        {
            Log::info($e->getMessage());
        }

    }
    public function goToPage($page)
    {
        $page = max(1, min($page, $this->addon['meta']['last_page'] ?? 1));
        $this->currentPage = $page;
        $this->addon = $this->getAddons($page); 
    }
}

<?php

namespace App\Livewire\Admin\Addon;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesGuzzleRequests;
use Livewire\WithFileUploads;
use GuzzleHttp\Client;
use Exception;
use Log;
use Auth;

class PurchaseHistory extends Component
{
    use HandlesGuzzleRequests;
    use WithFileUploads;

    public $user;
    public $purchase_histories;
    public $show_attachment=false;
    public $image;
    public $purchase_history_id;
    public $currentPage=1;

    public function mount()
    {
        $this->user = Auth::user();

        $this->purchase_histories = $this->getPurchaseHistory($this->currentPage);
        // dd($this->purchase_histories['data']);
    }
    public function render()
    {
        // dump($this->purchase_histories['meta']);
        // dd($this->purchase_histories['links']);
        return view('livewire.admin.addon.purchase-history',[
            'purchase_history_lists' => $this->purchase_histories['data'],
            'contact_detail' => $this->purchase_histories['contact'],
            'pagination' => [
                'meta' => $this->purchase_histories['meta'] ?? [],
                'links' => $this->purchase_histories['links'] ?? [],
            ]
        ]);
    }

    public function getPurchaseHistory($page)
    {

        $purchase_history_url = env('ADDON_API_URL') . '/api/addon/purchases';

        try {

            $response = $this->guzzleGet($purchase_history_url, [
                'email' => $this->user->email,
                'domain_name' => request()->getHost(),
                'page' => $page,
            ]);
            return $response;
        } 
        catch (Exception $e) 
        {
            Log::info($e->getMessage());
        }
    }
    public function openUploadModal($purchase_history_id)
    {
        $this->purchase_history_id = $purchase_history_id;
        $this->show_attachment = true;
    }
    public function uploadImage()
    {
        $this->validate([
            'image' => 'required|max:2048',
        ]);
        try{

            if($this->image)
            {
                $paymentUrl = env('ADDON_API_URL').'/api/update/purchase/attachment';

                $data =[
                    'payment_id' => $this->purchase_history_id,
                    'attachment_file'=>$this->image
                ];

                $response = $this->guzzleImagePost($paymentUrl, $data, true);

                if ($response->getStatusCode() === 200)
                {
                    $response= json_decode($response->getBody(), true);

                    \Session::put('successmessage',$response['message']);
                }
            }

            $this->show_attachment = false;
            
            $this->dispatch('#refresh');
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }
    }
    public function closeModal()
    {
        $this->show_attachment=false;
    }
    public function goToPage($page)
    {
        $page = max(1, min($page, $this->purchase_histories['meta']['last_page'] ?? 1));
        $this->currentPage = $page;
        $this->purchase_histories = $this->getPurchaseHistory($page);
    }

}

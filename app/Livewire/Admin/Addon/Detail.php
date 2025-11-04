<?php

namespace App\Livewire\Admin\Addon;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesGuzzleRequests;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Exception;
use Log;
use Auth;

class Detail extends Component
{
    use HandlesGuzzleRequests;

    public $addon_id;
    public $paymentgateways=[];
    public $payment_gateway;
    public $user;
    public $amount;
    public $addon_detail;
    public $paymentgateway_detail;
    public $gatewayname;
    public bool $isProcessing = false;
    public $addon_slug;

    public function mount($slug)
    {
        // $this->addon_id =$id;
        $this->addon_slug = $slug;
        $this->user=Auth::user();
        $this->paymentgateways = $this->getPaymentgateways();
        $this->addon_detail = $this->getAddonDetail();

    }
    public function render()
    {
        
        return view('livewire.admin.addon.detail',[
            'addondetail' => $this->addon_detail['data'],
            'contact_detail' => $this->addon_detail['contact'],
            'paymentgateways' => $this->paymentgateways,
            'addonfeatures' => $this->addon_detail['addon_features'],
        ]);
    }

    public function buyAddon()
    {
        if ($this->isProcessing) return; //check double click load
            $this->isProcessing = true;


        $validatedData = $this->validate([
            'payment_gateway' => 'required'
        ]);
        
        try{
            
            $gateway = collect($this->paymentgateways)->firstWhere('id', $this->payment_gateway);

            $status='pending';
            $create=[
                'addon_slug' => $this->addon_slug,
                'payment_gateway' => $this->payment_gateway,
                'domain_name' => request()->getHost(),
                'name' => $this->user->name,
                'email' => $this->user->email,
                'status' => $status,
                'amount' => $this->addon_detail['data']['price'],
                'mobile_no' => $this->user->mobile_no
            ];

            $apiUrl = env('ADDON_API_URL').'/api/'.'addon-purchase';

            $response = $this->guzzlePost($apiUrl, $create, true);

            if ($response && isset($response['success']) && $response['success']) 
            {
                $payment=$response['data'];
                
                $create['payment_id']=$payment['id'];

                if($gateway['gatewayname']=='razorpay')
                {
                    // \Session::put('addon_detail',$create);

                    // return redirect(url('admin/payment/razorpay/checkout'));

                    $paymentUrl = env('ADDON_API_URL').'/api/razorpay/payment';

                    $payment_response = $this->guzzlePost($paymentUrl, $create, true);
                    
                    if ($payment_response && isset($payment_response['success']) && $payment_response['success']) 
                    {

                        $this->dispatch('redirect-to-url', $payment_response['link']);
                        return;
                    }
                   
                }

                \Session::put('successmessage',$response['message']); 
            }


            return redirect(url('admin/addon/'.$this->addon_slug.'/detail'));

        }
        catch(Exception $e)
        {
            $this->isProcessing = false;
            Log::info($e->getMessage());

        }

        $this->isProcessing = false;
    }
    public function paymentGatewayChange()
    {
        $gateway = collect($this->paymentgateways)->firstWhere('id', $this->payment_gateway);

        $this->gatewayname=$gateway['gatewayname'];

        if ($gateway['gatewayname'] == 'bank') 
        {

            $apiUrl = env('ADDON_API_URL').'/api/paymentgateway/detail';

            $response = $this->guzzleGet($apiUrl, [
                'gatewayname' => $gateway['gatewayname'],
            ]);


            $this->paymentgateway_detail = $response['data'];

        }    
    }

    public function getAddonDetail()
    {

        $addon_url = env('ADDON_API_URL') . '/api/detail/'.$this->addon_slug ;

        try {

            $response = $this->guzzleGet($addon_url, [
                'email' => $this->user->email,
                'domain_name' => request()->getHost(),
                'addon_slug' => $this->addon_slug,
            ]);

            return $response;
        } 
        catch (\Exception $e) 
        {
            Log::info($e->getMessage());
        }
    }
    public function getPaymentgateways()
    {

        $api_url=env('ADDON_API_URL').'/api/paymentgateways';

        try {

            $response = $this->guzzleGet($api_url);

            return $response['data'];
        } 
        catch (\Exception $e) 
        {
            Log::info($e->getMessage());
        }
    }
}

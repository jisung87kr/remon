<?php
namespace App\Services;

use App\Models\UserShippingAddress;
use Illuminate\Http\Request;

class UserShippingService{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function store($params=[])
    {
        try {
            $validated = $this->request->validate([
                'title' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address_postcode' => 'required',
                'address' => 'required',
                'address_detail' => 'required',
                'address_extra' => 'nullable',
                'is_default' => 'nullable|boolean',
            ]);

            if($validated['is_default']){
                $this->request->user()->shippingAddresses()->update([
                    'is_default' => false,
                ]);
            }

            return $this->request->user()->shippingAddresses()->create($validated);
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function update(UserShippingAddress $userShippingAddress, $params=[])
    {
        try {
            $validated = $this->request->validate([
                'title' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address_postcode' => 'required',
                'address' => 'required',
                'address_detail' => 'required',
                'address_extra' => 'nullable',
                'is_default' => 'boolean',
            ]);

            if($validated['is_default']){
                $this->request->user()->shippingAddresses()->update([
                    'is_default' => false,
                ]);
            }

            return $userShippingAddress->update($validated);
        } catch (\Exception $e){
            throw $e;
        }
    }
}

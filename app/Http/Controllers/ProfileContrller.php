<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Enums\AddressType;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordUpdateRequest;

class ProfileContrller extends Controller
{
    public function view(Request $request)
    {
        /**  @var \App\Models\User $user */
        $user = $request->user();
        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;
        $shippingAddress = $customer->shippingAddress ?? new CustomerAddress(['type' => AddressType::Shipping]);
        $billingAddress = $customer->billingAddress?? new CustomerAddress(['type' => AddressType::Billing]);
        $countries = Country::query()->orderBy('name', 'asc')->get();
        // dd($customer ,$shippingAddress->attributesToArray() , $billingAddress->attributesToArray());
        return view('profile.view' , compact('customer', 'user','shippingAddress', 'billingAddress', 'countries'));
    }
    public function store(ProfileRequest $request)
    {
        $customerData = $request->validated();
        $shippingData = $customerData['shipping'];
        $billingData = $customerData['billing'];

        /** @var \App\Models\User $user */
        $user = $request->user();
        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;
        $customer->update($customerData);

        if ($customer->shippingAddress) {
            $customer->shippingAddress->update($shippingData);
        } else {
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;
            CustomerAddress::create($shippingData);
        }
        if ($customer->billingAddress) {
            $customer->billingAddress->update($billingData);
        } else {
            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            CustomerAddress::create($billingData);
        }

        $request->session()->flash('flash_message', 'Profile was successfully updated.');

        return redirect()->route('profile');
        // /**  @var \App\Models\User $user */
        // $user = $request->user();
        // /** @var \App\Models\Customer $customer */
        // $customer = $user->customer;
        // $customer->update($request->only('first_name', 'last_name'));
        // $shippingAddress = $customer->shippingAddress;
        // $shippingAddress->update($request->only('address1', 'address2', 'city', 'state', 'zipcode', 'country_code'));
        // $billingAddress = $customer->billingAddress;
        // $billingAddress->update($request->only('address1', 'address2', 'city', 'state', 'zipcode', 'country_code'));
        // return redirect()->route('profile.view');
    }

    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $passwordData = $request->validated();

        $user->password = Hash::make($passwordData['new_password']);
        $user->save();

        $request->session()->flash('flash_message', 'Your password was successfully updated.');

        return redirect()->route('profile');

        // $validated = $request->validateWithBag('updatePassword', [
        //     'current_password' => ['required', 'current_password'],
        //     'password' => ['required', Password::defaults(), 'confirmed'],
        // ]);

        // $request->user()->update([
        //     'password' => Hash::make($validated['password']),
        // ]);

    }
}

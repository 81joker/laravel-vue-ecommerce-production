<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at->diffForHumans(),
            'items' => $this->items,
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name

            // 'created_at' => $this->created_at,
            // 'items' => OrderItemResource::collection($this->items),
            // 'customer' => CustomerResource::make($this->customer),
            // 'created_by' => UserResource::make($this->createdBy),
            // 'status' => $this->status->label,
            // 'payment_method' => $this->payment_method->label,
            // 'payment_status' => $this->payment_status->label,
            // 'shipping_address' => AddressResource::make($this->shippingAddress),
            // 'billing_address' => AddressResource::make($this->billingAddress),
            // 'shipping_method' => ShippingMethodResource::make($this->shippingMethod),
            // 'payment_method' => PaymentMethodResource::make($this->paymentMethod),
        ];
    }
}

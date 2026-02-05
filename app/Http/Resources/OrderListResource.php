<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class OrderListResource extends JsonResource
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
            'status' => $this->status,
            'number_of_items' => $this->items()->count(),
            // 'customer' => new UserCustomerListResource($this->user),
            'customer' => [
                'id' => $this->user->id,
                'first_name' => $this->user->customer->first_name ?? '',
                'last_name' => $this->user->customer->last_name ?? '',
            ],
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}

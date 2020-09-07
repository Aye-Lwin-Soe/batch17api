<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static $wrap = 'subcategory';
    public function toArray($request)
    {
        return [
            'subcategory_id' => $this->id,
            'subcategory_name' => $this->name,
            'categoryname' => $this->category_id
        ];
    }
}

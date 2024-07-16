<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('components.actions', [
            'view' => route('people.show', $this->id),
            'edit' => route('people.show', $this->id),
            'delete' => route('people.delete', $this->id),
            'deleteMessage' => __('peoples.delete', ['name' => $this->name]),
            'id' => $this->id
        ])->render();

        return [
            'id' => $this->id,
            'type' => $this->type->value,
            'type_text' => $this->type->title(),
            'photo' => $this->photo,
            'photo_image' => asset($this->photo),
            'name' => $this->name,
            'surname' => $this->surname,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'email' => $this->email,
            'licence_no' => $this->licence_no,
            'actions' => $actions
        ];
    }
}

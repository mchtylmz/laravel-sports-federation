<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PunishmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('components.actions', [
            'delete' => route('punishment.delete', $this->id),
            'deleteMessage' => __('punishments.delete', ['reason' => $this->reason]),
            'id' => $this->id
        ])->render();

        return [
            'id' => $this->id,
            'name' => $this->people?->name,
            'surname' => $this->people?->surname,
            'fullname' => $this->people?->fullname,
            'photo' => $this->people?->photo,
            'photo_image' => asset($this->people?->photo),
            'reason' => $this->reason,
            'description' => $this->description,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'actions' => $actions
        ];
    }
}

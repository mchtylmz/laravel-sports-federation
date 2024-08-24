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
        $actionsData = [
            'delete' => route('punishment.delete', $this->id),
            'deleteMessage' => __('punishments.delete', ['reason' => $this->reason]),
            'id' => $this->id
        ];

        if (hasRole('superadmin') && userPermit(['mudur'])) {
            unset($actionsData['edit'], $actionsData['delete']);
        }

        $actions = view('components.actions', $actionsData)->render();

        return [
            'id' => $this->id,
            'license_no' => $this->people?->license_no,
            'name' => $this->people?->name,
            'surname' => $this->people?->surname,
            'fullname' => $this->people?->fullname,
            'federation_id' => $this->people?->federation?->id,
            'federation_name' => $this->people?->federation?->name,
            'photo' => $this->people?->photo,
            'photo_image' => asset($this->people?->photo),
            'reason' => $this->reason,
            'description' => $this->description,
            'type' => $this->people?->type?->value,
            'type_text' => $this->people?->type?->title(),
            'created_at' => $this->created_at?->format('Y-m-d'),
            'actions' => $actions
        ];
    }
}

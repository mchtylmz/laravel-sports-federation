<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FederationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('components.actions', [
            'view' => route('federation.show', $this->id),
            'edit' => route('federation.show', $this->id),
            'delete' => route('federation.delete', $this->id),
            'deleteMessage' => __('settings.federation_delete', ['name' => $this->name]),
            'id' => $this->id
        ])->render();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'logo_image' => asset($this->logo),
            'document_number' => $this->document_number,
            'branch_number' => $this->branch_number,
            'is_special' => $this->is_special,
            'website' => $this->website,
            'route_note' => route('federation.notes', $this->id),
            //'notes_count' => $this->notes()->count(),
            'notes_count' => sprintf(
                '%d / %d',
                $this->notes()->where('is_read', 0)->count(),
                $this->notes()->count()
            ),
            'is_special_text' => $this->is_special == 1 ? __('table.yes') : __('table.no'),
            'actions' => $actions
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Laravel\Prompts\spin;

class ClubResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actionsData = [
            'view' => route('club.show', $this->id),
        ];
        if (hasRole('superadmin')) {
            $actionsData = [
                ...$actionsData,
                'edit' => route('club.show', $this->id),
                'delete' => route('club.delete', $this->id),
                'deleteMessage' => __('settings.club_delete', ['name' => $this->name]),
                'id' => $this->id
            ];
        }

        $actions = view('components.actions', $actionsData)->render();

        return [
            'id' => $this->id,
            'federation_id' => $this->federation_id,
            'federation_count' => count(explode(',', $this->federation_id)),
            'name' => $this->name,
            'location' => $this->location,
            'region' => $this->region,
            'user_name' => $this->user_name,
            'user_phone' => $this->user_phone,
            'user_email' => $this->user_email,
            'user_info' => sprintf('%s - %s', $this->user_name, $this->user_phone ?: $this->user_email),
            'user_info_html' => sprintf('%s <br> %s', $this->user_name, $this->user_phone ?: $this->user_email),
            'status' => $this->status,
            'status_text' => trans('table.'.$this->status->value),
            'status_html' => sprintf('<span class="status %s">%s</span>', $this->status->value, trans('table.'.$this->status->value)),
            'actions' => $actions
        ];
    }
}

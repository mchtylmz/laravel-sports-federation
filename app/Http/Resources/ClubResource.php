<?php

namespace App\Http\Resources;

use App\Models\Federation;
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
        if (hasRole('admin')) {
            $actionsData = [
                ...$actionsData,
                'edit' => route('club.show', $this->id)
            ];
        }

        if (userPermit(['mudur'])) {
            unset($actionsData['edit'], $actionsData['delete']);
        }

        $actions = view('components.actions', $actionsData)->render();

        $federation_names = '';
        if ($ids = explode(',', $this->federation_id)) {
            if ($federations = Federation::whereIn('id', $ids)->get()) {
                $federation_names = [];
                foreach ($federations as $federation) {
                    $federation_names[] = $federation->name;
                }
            }
            $federation_names = implode('<br>', $federation_names);
        }

        return [
            'id' => $this->id,
            'federation_id' => $this->federation_id,
            'federation_names' => $federation_names,
            'federation_names_html' => $federation_names,
            'federation_count' => count(explode(',', $this->federation_id)),
            'name' => $this->name,
            'location' => $this->location,
            'region' => $this->region,
            'user_name' => $this->user_name,
            'user_phone' => $this->user_phone,
            'user_email' => $this->user_email,
            'user_info' => sprintf('%s - %s', $this->user_name, $this->user_phone ?: $this->user_email),
            'user_info_html' => sprintf('%s <br> %s', $this->user_name, $this->user_phone ?: $this->user_email),
            'tombala' => $this->when(!empty($this->tombala), 'Evet', 'Hayır'),
            'status' => $this->status,
            'status_text' => trans('table.'.$this->status->value),
            'status_html' => sprintf('<span class="status %s">%s</span>', $this->status->value, trans('table.'.$this->status->value)),
            'actions' => $actions
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actionsData = [
            'edit' => $this->id !== auth()->id() ? route('user.show', [$this->role, $this->id]) : false,
            'view' => route('user.show', [$this->role, $this->id]),
            'delete' => $this->id !== auth()->id() && hasRole('superadmin') ? route('user.delete', $this->id) : false,
            'deleteMessage' => __('users.delete', ['name' => $this->name]),
            'id' => $this->id
        ];

        if (userPermit(['mudur'])) {
            unset($actionsData['edit'], $actionsData['delete']);
        }

        $actions = view('components.actions', $actionsData)->render();

        return [
            'id' => $this->id,
            'federation_name' => $this->when($this->role == 'admin' && $this->getMeta('federation_id'), function () {
                return $this->federation()?->name;
            }),
            'identity_number' => $this->when($this->role == 'manager', $this->getMeta('identity_number')),
            'places_count' => $this->when($this->role == 'manager', function () {
                return $this->getMeta('places')?->count() ?? 0;
            }),
            'places_count_text' => $this->when($this->role == 'manager', function () {
                return sprintf(
                    '%d %s',
                    $this->getMeta('places')?->count() ?? 0,
                    trans('table.place')
                );
            }),
            'username' => $this->username,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'permit' => $this->permit?->value,
            'permit_text' => $this->permit?->title(),
            'created_at' => $this->created_at?->format('Y-m-d'),
            'last_login' => $this?->last_login?->format('Y-m-d'),
            'actions' => $actions
        ];
    }
}

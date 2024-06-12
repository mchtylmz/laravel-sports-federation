<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isPast = now()->format('Y-m-d') < $this->start_date?->format('Y-m-d');

        $actions = view('components.actions', [
            'edit' => route('event.show', $this->id),
            'delete' => $isPast ? route('event.delete', $this->id) : false,
            'deleteMessage' => __('events.delete', ['title' => $this->title]),
            'id' => $this->id
        ])->render();

        return [
            'id' => $this->id,
            'user_username' => $this->user?->username,
            'user_name' => $this->user?->name,
            'title' => $this->title,
            'location' => $this->location,
            'is_national' => $this->is_national,
            'is_national_text' => $this->is_national == 1 ? __('table.yes') : __('table.no'),
            'start_date' => sprintf('%s %s', $this->start_date?->format('Y-m-d'), $this->start_time),
            'end_date' => sprintf('%s %s', $this->end_date?->format('Y-m-d'), $this->end_time),
            'actions' => $actions
        ];
    }
}

<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'view' => route('event.show', $this->id),
            'edit' => route('event.show', $this->id),
            'delete' => $isPast ? route('event.delete', $this->id) : false,
            'deleteMessage' => __('events.delete', ['title' => $this->title]),
            'id' => $this->id
        ])->render();

        $data = [
            'id' => $this->id,
            'user_username' => $this->user?->username,
            'user_name' => $this->user?->name,
            'title' => $this->title,
            'content' => $this->content,
            'location' => $this->location,
            'is_national' => $this->is_national,
            'is_national_text' => $this->is_national == 1 ? __('table.national') : __('table.local'),
            'start_date' => sprintf('%s %s', $this->start_date?->format('Y-m-d'), $this->start_time),
            'start' => sprintf('%s %s', $this->start_date?->format('Y-m-d'), $this->start_time),
            'end_date' => sprintf('%s %s', $this->end_date?->format('Y-m-d'), $this->end_time),
            'end' => sprintf('%s %s', $this->end_date?->format('Y-m-d'), $this->end_time),
            'startStr' => Carbon::parse($this->start_date)->translatedFormat('d F Y l, H:i'),
            'end_notes' => $this->end_notes,
            'view_route' => route('event.show', $this->id) . '?format=json',
            'actions' => $actions
        ];

        return [
            ...$data,
            'startStr' => Carbon::parse($data['start_date'])->translatedFormat('d F Y l, H:i'),
            'endStr' => Carbon::parse($data['end_date'])->translatedFormat('d F Y l, H:i'),
            'backgroundColor' => $this->user?->getMeta('event_color') ?? 'blue',
            'textColor' => 'white',
            'display' => 'block'
        ];
    }
}

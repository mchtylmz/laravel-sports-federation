<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('components.actions', [
            'view' => route('log.show', $this->id),
            'id' => $this->id
        ])->render();

        return [
            'id' => $this->id,
            'username' => $this->user?->username,
            'name' => $this->user?->name,
            'table_name' => trans('log.table.' . ($this->table_name ?: 'empty')),
            'log_type' => $this->log_type ?: '-',
            'ip' => $this->ip,
            'log_date' => $this->log_date?->format('Y-m-d H:i'),
            'actions' => $actions
        ];
    }
}

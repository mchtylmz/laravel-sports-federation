<?php

namespace App\Http\Resources;

use App\Models\Club;
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
        $actionsData = [
            'view' => route('people.show', $this->id),
            'edit' => route('people.show', $this->id),
            'delete' => route('people.delete', $this->id),
            'deleteMessage' => __('peoples.delete', ['name' => $this->name]),
            'id' => $this->id
        ];

        if (hasRole('superadmin') && userPermit(['mudur'])) {
            unset($actionsData['edit'], $actionsData['delete']);
        }

        $actions = view('components.actions', $actionsData)->render();

        return [
            'id' => $this->id,
            'federation_id' => $this->federation?->id,
            'federation_name' => $this->federation?->name,
            'type' => $this->type->value,
            'type_text' => $this->type->title(),
            'photo' => $this->photo,
            'photo_image' => asset($this->photo),
            'name' => $this->name,
            'surname' => $this->surname,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'email' => $this->email,
            'license_no' => $this->license_no,
            'nationality' => $this->nationality,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date?->format('Y-m-d'),
            'registered_at' => $this->registered_at?->format('Y-m-d'),
            'licensed_at' => $this->licensed_at?->format('Y-m-d'),
            'adult' => $this->adult?->value,
            'adult_text' => $this->adult?->title(),
            'father_name' => $this->father_name,
            'gender' => $this->gender?->value,
            'gender_text' => $this->gender?->title(),
            'status' => $this->status?->value,
            'status_text' => $this->status?->title(),
            'player_club_id' => $this->getMeta('player_club_id'),
            'player_club_id_text' => Club::find($this->getMeta('player_club_id'))?->name,
            'referee_class' => $this->getMeta('referee_class'),
            'referee_region' => $this->getMeta('referee_region'),
            'coach_class' => $this->getMeta('coach_class'),
            'coach_job' => $this->getMeta('coach_job'),
            'racer_section' => $this->getMeta('racer_section'),
            'racer_car_brand' => $this->getMeta('racer_car_brand'),
            'racer_car_no' => $this->getMeta('racer_car_no'),
            'school_club_id' => $this->getMeta('player_club_id'),
            'school_club_id_text' => Club::find($this->getMeta('school_club_id'))?->name,
            'school_name' => $this->getMeta('school_name'),
            'school_document' => $this->getMeta('school_document'),
            'school_document_url' => $this->getMeta('school_document') ? asset($this->getMeta('school_document')) : '',
            'actions' => $actions
        ];
    }
}

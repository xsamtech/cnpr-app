<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'surname' => $this->surname,
            'gender' => $this->gender,
            'birth_city' => $this->birth_city,
            'birth_date' => $this->birth_date,
            'office' => $this->office,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'p_o_box' => $this->p_o_box,
            'phone' => $this->phone,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'email_verified_at' => $this->email_verified_at,
            'remember_token' => $this->remember_token,
            'api_token' => $this->api_token,
            'avatar_url' => !empty($this->avatar_url) ? getWebURL() . '/storage/' . $this->avatar_url : null,
            'office' => $this->office,
            'is_department_chief' => $this->is_department_chief,
            'status' => Status::make($this->status),
            'department' => Department::make($this->department),
            'roles' => Role::collection($this->roles),
            'tasks' => Task::collection($this->tasks),
            'branches' => Branch::collection($this->branches),
            'paid_unpaids' => PaidUnpaid::collection($this->paid_unpaids),
            'histories' => History::collection($this->histories),
            'notifications' => Notification::collection($this->notifications),
            'sessions' => Session::collection($this->sessions),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class Message extends JsonResource
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
            'message_subject' => $this->message_subject,
            'message_content' => $this->message_content,
            'answered_for' => $this->answered_for,
            'type' => Type::make($this->type),
            'status' => Status::make($this->status),
            'files' => File::collection($this->files),
            'user' => User::make($this->user),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_ago' => timeAgo($this->created_at->format('Y-m-d H:i:s')),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'updated_at_ago' => timeAgo($this->updated_at->format('Y-m-d H:i:s')),
            'addressee_role_id' => $this->addressee_role_id,
            'addressee_branch_id' => $this->addressee_branch_id,
            'addressee_department_id' => $this->addressee_department_id,
            'addressee_user_id' => $this->addressee_user_id
        ];
    }
}

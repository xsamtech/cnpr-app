<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class Task extends JsonResource
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
            'task_title' => $this->task_title,
            'task_content' => $this->task_content,
            'deadline' => $this->deadline,
            'performed_at' => $this->performed_at,
            'percentage_completed' => $this->percentage_completed,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user_id' => $this->user_id,
            'department_id' => $this->department_id
        ];
    }
}

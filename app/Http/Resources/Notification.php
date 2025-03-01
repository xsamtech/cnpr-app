<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class Notification extends JsonResource
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
            'notification_content' => $this->notification_content,
            'notification_url' => !empty($this->notification_url) ? getWebURL() . $this->notification_url : null,
            'icon' => $this->icon,
            'color' => $this->color,
            'status' => Status::make($this->status),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_ago' => timeAgo($this->created_at->format('Y-m-d H:i:s')),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'updated_at_ago' => timeAgo($this->updated_at->format('Y-m-d H:i:s')),
            'user_id' => $this->user_id
        ];
    }
}

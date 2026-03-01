<?php

namespace App\Http\Resources;

use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isOverdue = false;
        if ($this->due_date && $this->status !== TaskStatus::COMPLETED) {
            $isOverdue = $this->due_date->isPast();
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value ?? $this->status, // Support enum or string
            'priority' => $this->priority->value ?? $this->priority,
            'due_date' => $this->due_date ? $this->due_date->toISOString() : null,
            'completed_at' => $this->completed_at ? $this->completed_at->toISOString() : null,
            'is_overdue' => $isOverdue,
            'created_at' => $this->created_at ? $this->created_at->toISOString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toISOString() : null,
        ];
    }
}
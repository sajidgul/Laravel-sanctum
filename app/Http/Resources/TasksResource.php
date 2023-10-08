<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> (string)$this->id,
            'attributes'=> [
                'title'=> $this->title,
                // 'user'=>$this->user,
                'description'=>$this->description,
                'priority'=>$this->priority,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ],
            'relationships'=>[
                'id' => (string)$this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]
            ];
    }
}

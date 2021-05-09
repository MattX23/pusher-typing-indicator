<?php

namespace App\Http\Transformers;

use App\Models\Transformable;
use Carbon\Carbon;

class MessageTransformer extends Transformer
{
    /**
     * @param \App\Models\Transformable $message
     * @return array
     */
    public function transform(Transformable $message): array
    {
        return [
            'id'       => $message->id,
            'body'     => $message->body,
            'username' => $message->user->name,
            'timeAgo'  => Carbon::parse($message->created_at)->diffForHumans(),
            'userId'   => $message->user->id,
        ];
    }
}

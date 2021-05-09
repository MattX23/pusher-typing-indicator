<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Transformers\MessageTransformer;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): JsonResponse
    {
        return response()->json([
            'data' => [
                'messages' => (new MessageTransformer())->transformCollection(Message::all()),
            ]
        ]);
    }

    /**
     * @param \App\Http\Requests\StoreMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(StoreMessageRequest $request): JsonResponse
    {
        $message = Message::create([
           'user_id' => $request->input('user_id'),
           'body'    => $request->input('body'),
        ]);

        return response()->json([
            'data' => [
                'message' => (new MessageTransformer())->transform($message),
            ]
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreContactRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        $message = ContactMessage::query()->create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'message' => $request->string('message')->toString(),
            'consent' => true,
            'ip' => $request->ip(),
            'status' => ContactMessageStatus::New,
        ]);

        $to = SiteSetting::current()->email ?: config('mail.from.address');

        if (filled($to)) {
            Mail::to($to)->send(new ContactMessageReceived($message));
        }

        return response()->json([
            'data' => [
                'id' => $message->id,
                'message' => 'Спасибо! Сообщение отправлено, мы ответим в ближайшее время.',
            ],
        ], 201);
    }
}

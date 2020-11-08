<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailMessageRequest;
use App\Http\Resources\EmailMessageResource;
use App\Models\EmailMessage;
use App\Services\EmailMessageServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EmailMessageController extends Controller
{
    protected $service;

    public function __construct(EmailMessageServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return EmailMessageResource::collection($this->service->listItems());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmailMessageRequest $request
     *
     * @return JsonResponse
     */
    public function store(EmailMessageRequest $request)
    {
        if ($mail = $this->service->makeItem($request->all())) {
            return response()->json(['message' => "Email Message {$mail->subject} was successfully created", 'resource' => new EmailMessageResource($mail)],
                Response::HTTP_CREATED,
                ['Location' => route('mail.show', ['mail' => $mail->id])]);
        } else {
            return response()->json(['message' => 'Mail was not saved'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return EmailMessageResource
     */
    public function show($id)
    {
        return new EmailMessageResource($this->service->findItem($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmailMessageRequest $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function update(EmailMessageRequest $request, $id)
    {
        if ($mail = $this->service->editItem($id, $request->all())) {
            return response()->json(['message' => "{$mail->subject} was successfully updated", 'resource' => new EmailMessageResource($mail)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Mail was not updated'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $emailMessage = $this->service->findItem($id);
        try {
            if ($this->service->remove(Arr::wrap($id))) {
                return response()->json(['message' => "{$emailMessage->subject} was successfully removed"], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Mail was not removed'], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            Log::critical($e);
            return response()->json(['message' => 'Mail not removed, try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

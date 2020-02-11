<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends BaseController
{
    /**
     * Return generic json response with the given data.
     *
     * @param $data
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $statusCode = Response::HTTP_OK, $headers = [], $forceResponseFormat = false)
    {
        $data = is_object($data) ? (array)$data : $data;
        if(!$forceResponseFormat && isset($data['errors'])){
            if(!is_array($data['errors'])){
                $data['errors'] = [
                    'error' => [
                        $data['errors']
                    ]
                ];
            }
        }
        return response()->json($data, $statusCode, $headers);
    }

    /**
     * Respond with check exist content.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondContent($data = false)
    {
        if (!empty($data)) {
            return $data;
        }
        return $this->respondNoContent();
    }

    /**
     * Respond with no content.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNoContent()
    {
        return $this->respond(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Respond with not found.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound($errors = 'Not found', $statusCode = Response::HTTP_NOT_FOUND)
    {
        return $this->respond([
            'message'     => 'Resource not found',
            'errors'      => $errors,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    /**
     * Respond with success.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($data = ['message' => 'Success'])
    {
        return $this->respond($this->checkMessage($data));
    }

    /**
     * Respond with created.
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated($data = ['message' => 'Created successfully'])
    {
        return $this->respond($this->checkMessage($data), Response::HTTP_CREATED);
    }

    /**
     * Respond with error.
     *
     * @param $errors
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($errors = 'Undefined error', $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return $this->respond([
            'message'     => 'Bad request',
            'errors'      => $errors,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    /**
     * Respond with error subscription expired.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSubscriptionExpired()
    {
        return $this->respondError('Subscription has expired');
    }

    /**
     * Respond with validation error.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondValidationError(Validator $validator)
    {
        $message = 'The given data was invalid.';

        if (!empty($validator->errors()->getMessageBag())) {
            $message = '';
            foreach (json_decode($validator->errors()->getMessageBag()) as $error) {
                $message .= implode(' ', $error) . ' ';
            }
            $message = mb_substr($message, 0, -1);
        }

        return $this->respond([
            'message'     => $message,
            'errors'      => $validator->errors()->getMessageBag(),
            'status_code' => Response::HTTP_BAD_REQUEST,
        ], Response::HTTP_BAD_REQUEST);
    }

    protected function checkMessage($data)
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }
        return $data;
    }
}
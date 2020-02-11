<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

trait RestExceptionHandlerTrait
{
    use RestTrait;

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        if (!$this->isJsonRequest($request)) {
            return false;
        }

        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'message'     => 'Resource not found',
                'errors'      => [
                    'error' => [
                        $e->getMessage()
                    ]
                ],
                'status_code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);

        } else if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'message'     => 'Endpoint not found',
                'errors'      => [
                    'error' => [
                        $e->getMessage()
                    ]
                ],
                'status_code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);

        } else if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'message'     => $e->getMessage(),
                'errors'      => $e->errors(),
                'status_code' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);

        } else if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'message'     => 'Forbidden',
                'errors'      => [
                    'error' => [
                        $e->getMessage()
                    ]
                ],
                'status_code' => Response::HTTP_FORBIDDEN,
            ], Response::HTTP_FORBIDDEN);
        }else if ($e instanceof \Illuminate\Auth\AuthenticationException || strpos($e->getTraceAsString(), 'abort(403)') !== false) {
            return response()->json([
                'message'     => 'Forbidden',
                'errors'      => $e->getMessage(),
                'status_code' => Response::HTTP_FORBIDDEN,
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'message'     => 'Bad request',
            'errors'      => [
                'error' => [
                    $e->getMessage()
                ]
            ],
            'status_code' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);

    }

}
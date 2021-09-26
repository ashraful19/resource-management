<?php

namespace App\Exceptions;

use App\Traits\HasApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use HasApiResponses;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return $this->respondWithError($e->getMessage(), $e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return $this->respondWithError($e->getMessage(), [], Response::HTTP_UNAUTHORIZED);
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return $this->respondWithError($e->getMessage(), [], Response::HTTP_FORBIDDEN);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return $this->respondWithError($e->getMessage() ?: 'Not Found.', [], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                //message needs to be modified to not show model path
                return $this->respondWithError($e->getMessage(), [], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return $this->respondWithError($e->getMessage(), [], Response::HTTP_METHOD_NOT_ALLOWED);
            }
        });
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof AuthenticationException){
            return new JsonResponse([
                'error'=>['未授权']
            ],JsonResponse::HTTP_UNAUTHORIZED);
        }

        if($exception instanceof UnauthorizedException){
            return new JsonResponse([
                'error'=>['访问受限']
            ],JsonResponse::HTTP_FORBIDDEN);
        }

        if($exception instanceof ModelNotFoundException){

            return new JsonResponse([
                'error'=>['记录未找到']
            ],400);

        }


        if($exception instanceof  ValidationException){
            $errors = collect($exception->errors());
            return new JsonResponse([
                'error'=> $errors->flatten()
            ],400);
        }

        if($exception instanceof ReflectionException)
        {
            return new JsonResponse([
                'error'=> $exception->getMessage()
            ],400);
        }

        return parent::render($request, $exception);
    }
}

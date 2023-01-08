<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $data = [];
                $code = StatusCode::HTTP_INTERNAL_SERVER_ERROR;

                switch (true) {
                    // バリデーションエラー
                    case $e instanceof ValidationException:
                        /** @var ValidationException $e */
                        $code = $e->status;
                        $data = $this->errorData($e->errors());
                        break;
                    // 認証エラー
                    case $e instanceof AuthenticationException:
                        $code = StatusCode::HTTP_UNAUTHORIZED;
                        break;
                    // 不明なルート
                    case $e instanceof RouteNotFoundException:
                        $code = StatusCode::HTTP_NOT_FOUND;
                        break;
                    case $e instanceof HttpException:
                        /** @var HttpException $e */
                        $code = $e->getStatusCode();
                        $data = $this->errorData($e->getMessage());
                        break;
                    default:
                        break;
                }

                return response()->json($data, $code);
            }
            return;
        });
    }

    public function errorData(string|array $error): array
    {
        $errors = [];
        if (!$error) {
            return $errors;
        }

        if (is_string($error)) {
            $errors[] = $error;
        } elseif (is_array($error)) {
            $errors = $error;
        }

        return [
            'errors' => $errors,
        ];
    }
}

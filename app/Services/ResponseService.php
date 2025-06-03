<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    /**
     * Format response sukses
     */
    public static function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    /**
     * Format response error
     */
    public static function error(string $message = 'Error', $errors = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $errors,
            'message' => $message
        ], $code);
    }

    /**
     * Format response not found
     */
    public static function notFound(string $message = 'Data tidak ditemukan'): JsonResponse
    {
        return self::error($message, null, 404);
    }

    /**
     * Format response validation error
     */
    public static function validationError($errors, string $message = 'Validasi gagal'): JsonResponse
    {
        return self::error($message, $errors, 422);
    }

    /**
     * Format response server error
     */
    public static function serverError(string $message = 'Terjadi kesalahan server'): JsonResponse
    {
        return self::error($message, null, 500);
    }
} 
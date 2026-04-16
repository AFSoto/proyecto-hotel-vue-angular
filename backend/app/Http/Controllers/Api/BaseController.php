<?php

// Define el namespace donde está ubicado este controlador.
// Esto le dice a Laravel la ruta lógica de la clase.
namespace App\Http\Controllers\Api;

// Importa el controlador base de Laravel.
use App\Http\Controllers\Controller;

// Este controlador servirá como base para todos tus controladores de la API.
class BaseController extends Controller
{
    /**
     * Respuesta exitosa estandarizada.
     *
     * @param mixed  $data     Datos que deseas devolver (array, objeto, colección, etc.)
     * @param string $message  Mensaje opcional de éxito
     * @param int    $status   Código HTTP (200, 201, etc.)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success(mixed $data, string $message = 'OK', int $status = 200)
    {
        return response()->json([
            // Información principal de la respuesta
            'data'    => $data,

            // Mensaje descriptivo de éxito
            'message' => $message,
        ], $status);
    }

    /**
     * Respuesta de error estandarizada.
     *
     * @param string $message  Mensaje principal del error
     * @param int    $status   Código HTTP (400, 404, 500, etc.)
     * @param array  $errors   Lista adicional de errores o validaciones
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message, int $status = 400, array $errors = [])
    {
        // Se crea la estructura base del error
        $response = ['message' => $message];

        // Si existen errores adicionales, se agregan al response
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        // Devuelve respuesta JSON con el código HTTP indicado
        return response()->json($response, $status);
    }
}

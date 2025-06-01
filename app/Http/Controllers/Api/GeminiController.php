<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiAIService;
use Illuminate\Http\JsonResponse;

class GeminiController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiAIService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Generate text using Gemini AI
     * Endpoint: POST /api/gemini/generate
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'prompt' => 'required|string|max:8000',
                'type' => 'nullable|string|in:berita,pengumuman,sambutan',
                'params' => 'nullable|array'
            ]);

            $prompt = $request->input('prompt');
            $type = $request->input('type');
            $params = $request->input('params', []);

            // Generate content berdasarkan type
            switch ($type) {
                case 'berita':
                    $response = $this->geminiService->generateBerita(array_merge($params, ['topik' => $prompt]));
                    break;
                case 'pengumuman':
                    $response = $this->geminiService->generatePengumuman(array_merge($params, ['topik' => $prompt]));
                    break;
                case 'sambutan':
                    $response = $this->geminiService->generateSambutanKepsek(array_merge($params, ['acara' => $prompt]));
                    break;
                default:
                    $response = $this->geminiService->generateContent($prompt);
                    break;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'generated_text' => $response,
                    'type' => $type ?? 'general',
                    'model' => config('services.gemini.model'),
                    'prompt_length' => strlen($prompt),
                    'response_length' => strlen($response),
                    'timestamp' => now()->toISOString()
                ],
                'message' => 'Content generated successfully'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation Error',
                'messages' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Generation Failed',
                'message' => $e->getMessage(),
                'model' => config('services.gemini.model')
            ], 500);
        }
    }

    /**
     * Test Gemini AI connection
     * Endpoint: GET /api/gemini/test
     * 
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        try {
            $success = $this->geminiService->testConnection();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'status' => 'connected',
                    'model' => config('services.gemini.model'),
                    'api_available' => true,
                    'timestamp' => now()->toISOString()
                ],
                'message' => 'Gemini AI connection successful'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [
                    'status' => 'disconnected',
                    'model' => config('services.gemini.model'),
                    'api_available' => false,
                    'timestamp' => now()->toISOString()
                ],
                'error' => 'Connection Failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available models and configuration
     * Endpoint: GET /api/gemini/models
     * 
     * @return JsonResponse
     */
    public function models(): JsonResponse
    {
        try {
            $availableModels = $this->geminiService->getAvailableModels();
            $currentModel = config('services.gemini.model');
            $modelInfo = $this->geminiService->getModelInfo($currentModel);

            return response()->json([
                'success' => true,
                'data' => [
                    'current_model' => $currentModel,
                    'current_model_info' => $modelInfo,
                    'available_models' => $availableModels,
                    'api_configured' => !empty(config('services.gemini.api_key')),
                    'timestamp' => now()->toISOString()
                ],
                'message' => 'Model information retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve model information',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate content with advanced parameters
     * Endpoint: POST /api/gemini/generate-advanced
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function generateAdvanced(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'prompt' => 'required|string|max:8000',
                'temperature' => 'nullable|numeric|between:0,1',
                'max_tokens' => 'nullable|integer|between:1,8192',
                'top_k' => 'nullable|integer|between:1,100',
                'top_p' => 'nullable|numeric|between:0,1',
                'context' => 'nullable|string|max:2000'
            ]);

            $prompt = $request->input('prompt');
            $context = $request->input('context');
            
            // Add context to prompt if provided
            if ($context) {
                $prompt = "Konteks: {$context}\n\nTugas: {$prompt}";
            }

            $response = $this->geminiService->generateContent($prompt);

            return response()->json([
                'success' => true,
                'data' => [
                    'generated_text' => $response,
                    'model' => config('services.gemini.model'),
                    'parameters' => [
                        'temperature' => $request->input('temperature', 0.7),
                        'max_tokens' => $request->input('max_tokens', 8192),
                        'top_k' => $request->input('top_k', 40),
                        'top_p' => $request->input('top_p', 0.95),
                    ],
                    'prompt_with_context' => !empty($context),
                    'timestamp' => now()->toISOString()
                ],
                'message' => 'Advanced content generated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Advanced Generation Failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 
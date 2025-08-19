<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Carbon\Carbon;
use App\Models\Image;
use GuzzleHttp\Client;
class ApiService
{

    public function askQuestion($request)
    {
        $client = new Client();
        $apiKey = env('NEMATRON_AI_KEY'); // Make sure to add your OpenAI API key to the .env file

        try {
            $response = $client->post('https://integrate.api.nvidia.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' =>  $request->model,
                    'max_tokens' =>$request->max_tokens,
                    'stream' => $request->stream,
                    'temperature' => $request->temprature,
                    'top_p' => $request->top_p ,
                    'frequency_penalty' => $request->frequency_penalty,
                    'presence_penalty' => $request->presence_penalty,
                    'seed' => $request->seed,
                    'messages' => $request->messages,
                ],
                'verify' => false, // Disable SSL verification (not recommended for production)
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return [
                'success' => true,
                'message' => 'AI response retrieved successfully',
                'data' => $data['choices'][0]['message']['content'] ?? 'No response from AI',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving AI response: ' . $e->getMessage(),
            ];
        }
    }



    public function userDetails()
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User Not Found'
            ];
        }

        return ['success' => true, 'message' => 'User Details', 'data' => new UserResource($user)];
    }

    /**
     * Upload image 
     */
    function UploadImage($request)
    {
        $file = $request->file('file');

        $image = new Image();
        $imagePath = $image->uploadImage($file);
        $image->save();

        return response()->json([
            'message' => 'Image uploaded successfully',
            'image_path' => $imagePath
        ]);
    }


}


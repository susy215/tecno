<?php
namespace App\Services;

class AleledaBankService
{
    public function generateKhqrCode($amount)
    {
        // Example implementation. Replace with actual API call to Aleleda Bank
        $apiUrl = "https://api.aledabank.com/khqr";
        $apiKey = config('services.aledabank.api_key');

        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
        ])->post($apiUrl, [
            'amount' => $amount,
            // Add other required fields here
        ]);

        if ($response->successful()) {
            return $response->json()['qr_code_url'];
        }

        throw new \Exception("Failed to generate KHQR code");
    }
}


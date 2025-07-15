<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;


class MacroAnalyzerService
{
    public function analyze(string $mealDescription): array
    {
        $prompt = sprintf(config('constants.macro_prompt'), $mealDescription);

        $result = Gemini::generativeModel(model: 'gemini-2.0-flash')->generateContent($prompt);

        $text = $result->text();

        $cleanText = str_replace(['```json', '```', '```'], '', $text);

        return json_decode($cleanText, true);
    }
}

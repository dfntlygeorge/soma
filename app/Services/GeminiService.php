<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;


class GeminiService
{
    public function analyzeMeal(string $mealDescription): array
    {
        $prompt = sprintf(config('constants.macro_prompt'), $mealDescription);

        return $this->callGemini($prompt);
    }

    public function getRecommendedMacros(array $userInfo): array
    {
        $prompt = sprintf(
            config('constants.macro_recommendation_prompt'),
            $userInfo['age'],
            $userInfo['sex'],
            $userInfo['weight'],
            $userInfo['height'],
            $userInfo['activity_level'],
            $userInfo['goal']
        );

        return $this->callGemini($prompt);
    }

    public function suggestMeal(string $ingredientString, int $recommended_calories_for_next_meal): array
    {
        $prompt = sprintf(
            config('constants.meal_suggestion_prompt'),
            $ingredientString,
            $recommended_calories_for_next_meal
        );

        return $this->callGemini($prompt);
    }

    protected function callGemini(string $prompt): array
    {
        $result = Gemini::generativeModel(model: 'gemini-2.0-flash')->generateContent($prompt);

        $text = $result->text();
        $cleanText = str_replace(['```json', '```'], '', $text);

        return json_decode($cleanText, true);
    }
}

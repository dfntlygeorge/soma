<?php

return [
    'macro_prompt' => <<<PROMPT
I ate %s. First, rewrite or clean up this description to be clear and professional (for example: "100g chicken pastil with 50g white rice").

Then, estimate and calculate the total calories, protein, carbs, and fat content of this meal as accurately as possible.

Return **only** a pure JSON object with the following keys (no extra text, no explanations):

{
  "description": string (the cleaned-up, final meal description),
  "total_calories": integer (just a number, no units or words),
  "protein": integer (grams, just a number, no "g"),
  "carbs": integer (grams, just a number, no "g"),
  "fat": integer (grams, just a number, no "g")
}

⚠️ Important: All numeric values must be returned as plain integers only (e.g., 350, not "350 kcal" or "350 grams").

✅ Example of correct response:

{
  "description": "100g chicken pastil with 50g white rice",
  "total_calories": 350,
  "protein": 30,
  "carbs": 40,
  "fat": 10
}

Make sure to include only the JSON object and nothing else (no code fences, no markdown, no extra explanation). This response will be parsed by a program.
PROMPT,
];

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

  'macro_recommendation_prompt' => <<<PROMPT
Given the following user profile, estimate appropriate daily calorie, protein, carbs, and fat targets to help them achieve their goal. Use standard nutritional science guidelines.

User Info:
- Age: %s
- Sex: %s
- Weight: %s kg
- Height: %s cm
- Activity Level: %s
- Goal: %s

Return **only** a JSON object with the following keys (no extra explanation, no markdown):

{
  "calories": integer (daily calorie target),
  "protein": integer (grams),
  "carbs": integer (grams),
  "fat": integer (grams)
}

⚠️ Important: All values must be plain integers only. No units, no descriptions.

✅ Example:

{
  "calories": 2200,
  "protein": 160,
  "carbs": 250,
  "fat": 70
}

Only return the JSON object — no comments, no markdown, no explanation.
PROMPT,

  'meal_suggestion_prompt' => <<<PROMPT
You're a helpful meal planner AI. Based on the user's pantry and remaining daily calories, suggest one meal idea that fits within the calorie limit. Use common Filipino comfort food or creative "hugot"-style names and fun descriptions.

Ingredients available: %s
Remaining calories: %s

Respond with a JSON object in this format:

{
  "name": "Heartbreak Fried Rice",
  "description": "Comfort food for when bae left you on read. Garlic rice with spam, egg, and leftover tears of joy.",
  "calories": 420,
  "protein": 25,
  "carbs": 45,
  "fat": 18,
  "pantry_match": "85"
}

Only return the JSON object — no code blocks, no explanation, no extra text.
PROMPT,
];

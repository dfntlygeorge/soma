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
You are a nutrition-aware meal planning assistant. Based on the user's available ingredients and their remaining daily calorie budget, suggest **three** unique Filipino-inspired meal ideas that fit within the calorie limit.

Guidelines:
- The meal **name** should be formal and descriptive (e.g., “Chicken Adobo Bowl”, “Sauteed Tofu with Vegetables”) — avoid joke names or overly playful titles.
- The **description** should include a short, humorous or emotionally relatable *hugot-style* line — think hopeless romantic or witty but still light and tasteful.
- Each meal should include an estimated breakdown of calories, protein, carbs, and fat.
- Include a `pantry_match` score (percentage of ingredients matched from the user's pantry).
- Do **not** reuse the sample meals below — generate new suggestions each time.

Ingredients available: %s  
Remaining calories: %s  

Respond with a JSON array of 3 meal objects in this format:
[
  {
    "name": "Chicken Adobo Bowl",
    "description": "Tender adobo chicken served with steamed rice and sautéed kangkong — because unlike some people, this one won’t leave you hanging after being well-seasoned.",
    "calories": 430,
    "protein": 32,
    "carbs": 40,
    "fat": 18,
    "pantry_match": 90
  },
  {
    "name": "Gising-Gising with Ground Pork",
    "description": "Spicy green beans in creamy coconut milk with ground pork — proof that being hot and messy can still be comforting.",
    "calories": 390,
    "protein": 28,
    "carbs": 22,
    "fat": 24,
    "pantry_match": 85
  },
  {
    "name": "Tinolang Manok",
    "description": "Chicken tinola with malunggay and papaya — for the days when you just want something warm to hold onto, even if it’s just sabaw.",
    "calories": 360,
    "protein": 30,
    "carbs": 18,
    "fat": 16,
    "pantry_match": 88
  }
]

Only return the raw JSON array — no code blocks, no explanation, no extra text.
PROMPT,

];

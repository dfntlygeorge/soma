<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Services\GeminiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class CharmyController extends Controller
{
    private GeminiService $geminiService;
    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }
    // show index

    public function index()
    {
        return view("charmy.index");
    }

    public function suggestFromHistory()
    {
        // get user's kcal left for today i think we can make a this just inside this Controller itself. and maybe make this dynamic like if user have no logged meals except snack we divide it. Like let's say user has no logged meal meaning it's their first meal. so the kcal left is 1800 that means we can divide it by 3, and let's say it's second meal so we can divide the kcal left to two and so on.


        $user = auth()->user();

        $meals = $user->meals()->whereDate('date', Carbon::today())->get();

        // ✅ Exclude 'Snack' category from count
        $main_meals = $meals->filter(fn($meal) => strtolower($meal->category) !== 'snack');

        $total_calories = $meals->sum('total_calories'); // still sum all calories (including snacks)
        $meals_count = $main_meals->count();

        $daily_calorie_target = $user->daily_calorie_target;
        $calories_left = max($daily_calorie_target - $total_calories, 0);

        // 🔁 Divide remaining kcal based on how many main meals left
        $remaining_meals = max(3 - $meals_count, 1); // assume 3 main meals per day
        $recommended_calories_for_next_meal = intval($calories_left / $remaining_meals);

        // 🔁 Get unique meals from the user's past history (not today), within kcal range
        $suggested_meals = Meal::where('user_id', $user->id)
            ->whereDate('date', '<', Carbon::today())
            ->whereBetween('total_calories', [
                intval($recommended_calories_for_next_meal * 0.85),
                intval($recommended_calories_for_next_meal * 1.15)
            ])
            ->inRandomOrder()
            ->take(3)
            ->get();
        // util function to get 1-3 meals from the database that is within the user's kcal left.
        // pass the suggestions to the /charmy page

        return view('charmy.index', [
            'suggestions' => $suggested_meals
        ]);
    }

    public function suggestAi()
    {
        // Rate limiting check
        $key = 'suggest_' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return redirect()->route('rate-limit-exceeded')
                ->with('feature', 'AI Meal Suggestions')
                ->with('limit', '5 times per day');
        }

        // Increment the rate limiter
        RateLimiter::hit($key, 86400); // 86400 seconds = 24 hours

        $user = auth()->user();
        $meals = $user->meals()->whereDate('date', Carbon::today())->get();

        // ✅ Exclude 'Snack' category from count
        $main_meals = $meals->filter(fn($meal) => strtolower($meal->category) !== 'snack');

        $total_calories = $meals->sum('total_calories'); // still sum all calories (including snacks)
        $meals_count = $main_meals->count();

        $daily_calorie_target = $user->daily_calorie_target;
        $calories_left = max($daily_calorie_target - $total_calories, 0);

        // 🔁 Divide remaining kcal based on how many main meals left
        $remaining_meals = max(3 - $meals_count, 1); // assume 3 main meals per day
        $recommended_calories_for_next_meal = intval($calories_left / $remaining_meals);

        $ingredients = $user->ingredients;

        // ✅ Get a comma-separated string of ingredient names
        $ingredientString = $ingredients->pluck('name')->implode(', ');

        // pass in the recommended_calories_for_next_meal and ingredients string to the service
        $suggested_meals = $this->geminiService->suggestMeal($ingredientString, $recommended_calories_for_next_meal);

        return view('charmy.index', [
            'suggestions' => $suggested_meals
        ]);
    }
}
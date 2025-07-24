{{-- resources/views/rate-limit/exceeded.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>

                <h2 class="text-xl font-semibold text-gray-900 mb-2">Daily Limit Reached</h2>

                <p class="text-gray-600 mb-4">
                    You've reached the daily usage limit for <strong>{{ $feature }}</strong>
                    ({{ $limit }}). This limit helps us manage our testing resources effectively.
                </p>

                <p class="text-sm text-gray-500 mb-6">
                    Please try again tomorrow! Your usage limit will reset at midnight.
                </p>

                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}"
                        class="w-full inline-flex justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Return to Dashboard
                    </a>

                    <p class="text-xs text-gray-400">
                        <em>Note: This feature is currently in testing phase. Limits may be adjusted based on usage
                            patterns.</em>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

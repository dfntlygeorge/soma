@if ($onboarded)
    <div {{ $attributes->merge(['class' => 'alert alert-info mb-4']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ $slot->isEmpty() ? 'You’re editing your saved information.' : $slot }}</span>
    </div>
@endif

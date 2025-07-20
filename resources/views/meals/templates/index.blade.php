<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    TITE
    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-olive-900/50 border border-olive-600 text-olive-200 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-olive-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

</div>

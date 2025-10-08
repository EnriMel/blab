<x-app-layout>
    <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('blabs.store') }}">
            @csrf
            <textarea name="message" id="" cols="30" rows="10"
                placeholder="{{ __('A cosa stai pensando?') }}"
                class="block w-full rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2"></x-input-error>
            <x-primary-button class="mt-2">{{ __('Pubblica') }}</x-primary-button>
        </form>
        <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
            @foreach ($blabs as $blab)
                <div class="flex space-x-2 p-6">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 -scale-x-100 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">

                            <div>
                                <span class="text-gray-800">{{ $blab->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $blab->created_at->format('d M Y, H:i') }}</small>
                                @unless ($blab->created_at->eq($blab->updated_at))
                                    <small class="text-sm text-gray-600"
                                        &middot;{{ __('edited') }}</small>
                                    @endunless
                            </div>
                            {{-- the authenticated user is the owner --}}
                            @if ($blab->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name='trigger'>
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name='content'>
                                        <x-dropdown-link
                                            :href="route('blabs.edit', $blab)">{{ __('Edit') }}</x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            @endif

                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $blab->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('blabs.store') }}">
            @csrf
            <textarea name="message" id="" cols="30" rows="10"
                placeholder="{{ __('A cosa stai pensando?') }}"
                class="block w-full rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2"></x-input-error>
            <x-primary-button
                class="mt-2">{{ __('Pubblica') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>

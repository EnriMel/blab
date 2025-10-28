<x-app-layout>
   <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
      <form method="POST" action="{{ route('blabs.store') }}">
         @csrf
         <textarea rows=5 id="blab-message" name="message" id="" cols="30" rows="10"
            placeholder="{{ __('What are you thinking?') }}"
            class="block w-full rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
         <x-input-error :messages="$errors->get('message')" class="mt-2"></x-input-error>
         <x-primary-button class="mt-2">{{ __('Pubblica') }}</x-primary-button>
         <x-secondary-button id="suggest-blab" class="mt-2">{{ __('Suggerimento') }}

         </x-secondary-button>
      </form>
      <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
         @foreach ($blabs as $blab)
            <div class="flex space-x-2 p-6">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -scale-x-100 text-gray-600" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                     d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
               </svg>
               <div class="flex-1">
                  <div class="flex items-center justify-between">

                     <div>
                        <span class="text-gray-800">{{ $blab->user->name }}</span>
                        <small class="ml-2 text-sm text-gray-600">{{ $blab->created_at->format('d M Y, H:i') }}</small>
                        @unless ($blab->created_at->eq($blab->updated_at))
                           <small class="text-sm text-gray-600" &middot;{{ __('edited') }}</small>
                           @endunless
                     </div>
                     {{-- the authenticated user is the owner --}}
                     @if ($blab->user->is(auth()->user()))
                        <x-dropdown>
                           <x-slot name='trigger'>
                              <button>
                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                       d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                 </svg>
                              </button>
                           </x-slot>
                           <x-slot name='content'>
                              <x-dropdown-link :href="route('blabs.edit', $blab)">{{ __('Edit') }}
                              </x-dropdown-link>
                              <form action="{{ route('blabs.destroy', $blab) }}" method="POST">
                                 @csrf
                                 @method('delete')
                                 <x-dropdown-link :href="route('blabs.destroy', $blab)"
                                    onclick="event.preventDefault(); this.closest('form').submit()">{{ __('Delete') }}
                                 </x-dropdown-link>
                              </form>
                           </x-slot>
                        </x-dropdown>
                     @endif

                  </div>
                  <p class="mt-4 text-lg text-gray-900">
                     {{ $blab->message }}</p>
               </div>
            </div>
         @endforeach
      </div>
   </div>
</x-app-layout>

<script>
   document.getElementById('suggest-blab').addEventListener('click', async () => {
      const textarea = document.getElementById('blab-message');
      const blab = textarea.value;
      if (!blab.trim()) {
         alert('Per favore scrivi qualcosa!');
         return
      }
      try {
         console.log('Sending request...');
         // effettuiamo la richiesta alla rotta
         const response = await fetch("{{ route('blabs.suggest') }}", {
            method: "POST",
            headers: {
               'Content-Type': 'application/json',
               "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
               blab
            })
         });
         console.log("Richiesta inviata!", response);

         // inseriamo dinamicamente la risposta nella textarea
         const data = await response.json();

         // se è andato tutto bene sostituisco il contenuto della textarea con
         // il suggerimento del chatbot
         if (data.suggestion) {
            textarea.value = data.suggestion;
         } else {
            alert('Nessun suggerimento ricevuto.');
         }
      } catch (error) {
         console.error('Error fetching suggestion: ', error);
         alert('Qualcosa è andato storto');
      }
   });
</script>

<x-app-layout>
    <div class="w-full max-w-4xl mx-auto bg-white card">
        @error('name')
            <div class="p-4">
                <div role="alert" class="w-full alert alert-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ $message }}</span>
                    <button type="button" class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @enderror

        <form action="/bahagian" method="POST" class="card-body">
            @csrf
            <h3>Isi nama bahagian</h3>
            <input type="text" placeholder="Nama bahagian" name="name"
                class="w-full max-w-xs input @error('name') input-error @enderror input-bordered"
                value="{{ old('name') }}">
            <div class="flex justify-end w-full">
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</x-app-layout>

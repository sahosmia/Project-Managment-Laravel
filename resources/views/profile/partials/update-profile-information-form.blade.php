<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture -->
        <div class="flex flex-col items-center space-y-4">
            <div class="relative">
                <div id="avatar-preview"
                    class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center border-2 border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                    @if ($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                    <i class="fas fa-user text-5xl text-gray-400 dark:text-gray-500"></i>
                    @endif
                </div>
                <label for="avatar"
                    class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 transition shadow-lg">
                    <i class="fas fa-camera"></i>
                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*"
                        onchange="previewImage(this)">
                </label>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Allowed JPG, GIF or PNG. Max size of 2MB</p>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full input"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full input"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>
        @if (auth()->user()->hasRole('student'))
        <div>
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full input"
                :value="old('student_id', $user->student_id)" required autofocus autocomplete="student_id" />
            <x-input-error class="mt-2" :messages="$errors->get('student_id')" />
        </div>
        @endif
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full input"
                :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        @if (auth()->user()->hasRole('faculty_member'))
        <div>
            <x-input-label for="r_cell_id" :value="__('R-Cell')" />
            <select id="r_cell_id" name="r_cell_id" class="mt-1 block w-full input">
                <option value="">Select R-Cell</option>
                @foreach ($rCells as $rCell)
                <option value="{{ $rCell->id }}" @selected(old('r_cell_id', $user->r_cell_id) == $rCell->id)>
                    {{ $rCell->name }}
                </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('r_cell_id')" />
        </div>
        @endif


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('avatar-preview');
                preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

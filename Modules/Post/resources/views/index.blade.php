@extends('layouts.admin')

@section('content')

<div class="max-w-2xl mx-auto flex flex-col gap-4">

    @foreach ($posts as $post)

    @php
    $userLike = $post->likes->where('user_id', auth()->id())->first();
    @endphp

    <div class="bg-white rounded-lg shadow-sm border relative">

        <!-- Header -->
        <div class="flex items-center justify-between p-3">

            <div class="flex items-center gap-3">
                <img src="{{ $post->user->profile_photo_url ?? asset('images/avatar.png') }}"
                    class="w-10 h-10 rounded-full object-cover">

                <div>
                    <p class="font-semibold text-sm">
                        {{ $post->user->name }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $post->project->title }}
                        ·
                        {{
                        $post->created_at->isToday() || $post->created_at->isYesterday()
                        ? $post->created_at->diffForHumans()
                        : $post->created_at->format('d M Y')
                        }}
                    </p>
                </div>
            </div>

            {{-- Pinned badge --}}
            @if($post->is_pinned)
            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                📌 Pinned
            </span>
            @endif

            <!-- 3 Dots Menu (Only Owner) -->
            @if($post->user_id === auth()->id())
            <div class="relative">
                <button class="dots-btn text-xl px-2">⋮</button>

                <div class="dots-menu hidden absolute right-0 mt-2 w-28 bg-white border rounded shadow z-10">
                    <a href="{{ route('posts.edit', $post) }}" class="block px-3 py-1 text-sm hover:bg-gray-100">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')
                        <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 text-red-600">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </div>

        <!-- Content -->
        <div class="px-3 pb-3 text-sm text-gray-800">
            {{ $post->content }}
        </div>

        <!-- Actions -->
        <div class="border-t px-3 py-2 text-sm text-gray-600 flex justify-between items-center">

            <!-- Likes -->
            <div class="flex gap-4">

                <button class="like-btn {{ $userLike?->type === 'like' ? 'text-blue-600 font-semibold' : '' }}"
                    data-id="{{ $post->id }}" data-type="like">
                    👍 {{ $post->likes->where('type','like')->count() }}
                </button>

                <button class="like-btn {{ $userLike?->type === 'love' ? 'text-red-600 font-semibold' : '' }}"
                    data-id="{{ $post->id }}" data-type="love">
                    ❤️ {{ $post->likes->where('type','love')->count() }}
                </button>

                <button class="like-btn {{ $userLike?->type === 'dislike' ? 'font-semibold' : '' }}"
                    data-id="{{ $post->id }}" data-type="dislike">
                    👎 {{ $post->likes->where('type','dislike')->count() }}
                </button>

            </div>

            <!-- Comment Toggle -->
            <button class="toggle-comment">
                💬 {{ $post->comments->count() }} Comment
            </button>

        </div>

        <!-- Comment Section -->
        <div class="comment-box hidden border-t p-3">

            <!-- Comment List -->
            <div class="space-y-2 mb-3">
                @foreach ($post->comments as $comment)
                <div class="bg-gray-50 p-2 rounded text-sm">
                    <div class="flex justify-between">
                        <span class="font-semibold">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-500">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p>{{ $comment->comment }}</p>
                </div>
                @endforeach
            </div>

            <!-- Comment Form -->
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <div class="flex gap-2">
                    <input type="text" name="comment" class="w-full border rounded px-2 py-1 text-sm"
                        placeholder="Write a comment..." required>

                    <button class="bg-blue-600 text-white px-3 rounded text-sm">
                        Post
                    </button>
                </div>
            </form>

        </div>

    </div>

    @endforeach

</div>

@endsection

{{-- ================= JS ================= --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    /* Like Button */
$('.like-btn').click(function () {
    let btn = $(this);

    $.post("{{ route('post.like') }}", {
        _token: "{{ csrf_token() }}",
        post_id: btn.data('id'),
        type: btn.data('type')
    }, function () {
        location.reload(); // simple & stable
    });
});

/* Comment Toggle */
$('.toggle-comment').click(function () {
    $(this).closest('.bg-white').find('.comment-box').toggleClass('hidden');
});

/* 3 Dots Menu */
$('.dots-btn').click(function (e) {
    e.stopPropagation();
    $('.dots-menu').addClass('hidden');
    $(this).next('.dots-menu').toggleClass('hidden');
});

$(document).click(function () {
    $('.dots-menu').addClass('hidden');
});
</script>
@endpush
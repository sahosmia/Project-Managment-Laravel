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
                        {{ $post->created_at->isToday() || $post->created_at->isYesterday()
                        ? $post->created_at->diffForHumans()
                        : $post->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Pinned badge --}}
            @if ($post->is_pinned)
            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                📌 Pinned
            </span>
            @endif

            <!-- 3 Dots Menu (Only Owner) -->
            @if ($post->user_id === auth()->id())
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
                    👍 {{ $post->likes->where('type', 'like')->count() }}
                </button>

                <button class="like-btn {{ $userLike?->type === 'love' ? 'text-red-600 font-semibold' : '' }}"
                    data-id="{{ $post->id }}" data-type="love">
                    ❤️ {{ $post->likes->where('type', 'love')->count() }}
                </button>

                <button class="like-btn {{ $userLike?->type === 'dislike' ? 'font-semibold' : '' }}"
                    data-id="{{ $post->id }}" data-type="dislike">
                    👎 {{ $post->likes->where('type', 'dislike')->count() }}
                </button>

            </div>

            <!-- Comment Toggle -->
            <button class="toggle-comment text-sm text-gray-600">
                💬 <span class="comment-count">
                    {{ $post->comments->count() + $post->comments->sum(fn($c) => $c->replies->count()) }}
                </span> Comment
            </button>

        </div>





        <div class="comment-box hidden border-t relative max-h-64 overflow-y-auto">

            <!-- Sticky Comment Input -->
            <form class="comment-form sticky top-0 z-10 bg-white p-3 border-b flex gap-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <input type="text" name="comment" class="comment-input w-full border rounded px-2 py-1 text-sm"
                    placeholder="Write a comment..." required>

                <button class="bg-blue-600 text-white px-3 rounded text-sm">
                    Post
                </button>
            </form>

            <!-- Comment List -->
            <div class="comment-list space-y-3 p-3">

                @foreach ($post->comments as $comment)
                <div class="comment-item bg-gray-50 p-2 rounded text-sm" data-id="{{ $comment->id }}">

                    <!-- Comment Header -->
                    <div class="flex justify-between">
                        <div>
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>

                        @if ($comment->user_id === auth()->id())
                        <div class="text-xs space-x-2">
                            <button class="edit-comment text-blue-600">Edit</button>
                            <button class="delete-comment text-red-600">Delete</button>
                        </div>
                        @endif
                    </div>

                    <p class="comment-text mt-1">{{ $comment->comment }}</p>

                    <!-- Edit Box -->
                    <div class="edit-box hidden mt-2">
                        <input type="text" class="edit-input w-full border rounded px-2 py-1 text-sm"
                            value="{{ $comment->comment }}">
                        <button class="save-edit text-blue-600 text-sm mt-1">Save</button>
                    </div>

                    <!-- Actions -->
                    <div class="text-xs mt-1 space-x-3">
                        <button class="reply-btn text-blue-600">Reply</button>

                        @if ($comment->replies->count())
                        <button class="toggle-replies text-gray-600">
                            View {{ $comment->replies->count() }} replies
                        </button>
                        @endif
                    </div>

                    <!-- Reply Input -->
                    <div class="reply-box hidden mt-2">
                        <input type="text" class="reply-input w-full border rounded px-2 py-1 text-sm"
                            placeholder="Write a reply...">
                        <button class="send-reply text-blue-600 text-sm mt-1">
                            Reply
                        </button>
                    </div>

                    <!-- Replies -->
                    <div class="reply-list hidden ml-4 mt-2 space-y-2">
                        @foreach ($comment->replies as $reply)
                        <div class="reply-item bg-white border p-2 rounded text-xs" data-id="{{ $reply->id }}">

                            <div class="flex justify-between">
                                <div>
                                    <span class="font-semibold">{{ $reply->user->name }}</span>
                                    · {{ $reply->created_at->diffForHumans() }}
                                </div>

                                @if ($reply->user_id === auth()->id())
                                <div class="space-x-1">
                                    <button class="edit-reply text-blue-600">Edit</button>
                                    <button class="delete-reply text-red-600">Delete</button>
                                </div>
                                @endif
                            </div>

                            <p class="reply-text mt-1">{{ $reply->comment }}</p>

                            <div class="reply-edit-box hidden mt-1">
                                <input type="text" class="reply-edit-input w-full border rounded px-2 py-1 text-xs"
                                    value="{{ $reply->comment }}">
                                <button class="save-reply-edit text-blue-600 text-xs mt-1">
                                    Save
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                @endforeach

            </div>
        </div>

    </div>
    @endforeach

</div>
@endsection

{{-- ================= JS ================= --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    /* ================= GLOBAL HELPERS ================= */
function setCount(postContainer, count) {
    postContainer.find('.comment-count').text(count);
}

function updateCount(postContainer, change) {
    let countEl = postContainer.find('.comment-count');
    let currentCount = parseInt(countEl.text()) || 0;
    let newCount = Math.max(0, currentCount + change);
    countEl.text(newCount);
}

/* ================= LIKE ================= */
$(document).on('click', '.like-btn', function () {
    let btn = $(this);

    $.post("{{ route('post.like') }}", {
        _token: "{{ csrf_token() }}",
        post_id: btn.data('id'),
        type: btn.data('type')
    }, function () {
        location.reload();
    });
});

/* ================= TOGGLE COMMENT BOX ================= */
$(document).on('click', '.toggle-comment', function () {
    $(this).closest('.bg-white').find('.comment-box').toggleClass('hidden');
});

/* ================= CREATE COMMENT ================= */
$(document).on('submit', '.comment-form', function (e) {
    e.preventDefault();

    let form = $(this);
    let postContainer = form.closest('.bg-white');
    let list = postContainer.find('.comment-list');
    let input = form.find('.comment-input');

    $.post("{{ route('comments.store') }}", {
        _token: "{{ csrf_token() }}",
        post_id: form.find('input[name="post_id"]').val(),
        comment: input.val()
    }, function (res) {
        if (res.status) {
            list.append(`
                <div class="comment-item bg-gray-50 p-2 rounded text-sm" data-id="${res.data.id}">
                    <div class="flex justify-between">
                        <div>
                            <span class="font-semibold">${res.data.user}</span>
                            <span class="text-xs text-gray-500">${res.data.time}</span>
                        </div>
                        <div class="text-xs space-x-2">
                            <button class="edit-comment text-blue-600">Edit</button>
                            <button class="delete-comment text-red-600">Delete</button>
                        </div>
                    </div>

                    <p class="comment-text mt-1">${res.data.comment}</p>

                    <div class="edit-box hidden mt-2">
                        <input type="text" class="edit-input w-full border rounded px-2 py-1 text-sm"
                               value="${res.data.comment}">
                        <button class="save-edit text-blue-600 text-sm mt-1">Save</button>
                    </div>

                    <div class="text-xs mt-1 space-x-3">
                        <button class="reply-btn text-blue-600">Reply</button>
                    </div>

                    <div class="reply-box hidden mt-2">
                        <input type="text" class="reply-input w-full border rounded px-2 py-1 text-sm"
                               placeholder="Write a reply...">
                        <button class="send-reply text-blue-600 text-sm mt-1">Reply</button>
                    </div>

                    <div class="reply-list hidden ml-4 mt-2 space-y-2"></div>
                </div>
            `);

            input.val('');
            
            // If backend doesn't return total_count, update locally
            if (res.total_count !== undefined) {
                setCount(postContainer, res.total_count);
            } else {
                updateCount(postContainer, 1);
            }
        }
    });
});

/* ================= DELETE COMMENT (WITH REPLIES) ================= */
$(document).on('click', '.delete-comment', function () {
    let item = $(this).closest('.comment-item');
    let postContainer = item.closest('.bg-white');
    let id = item.data('id');
    let replyCount = item.find('.reply-item').length;
    let totalToDelete = 1 + replyCount;

    if (!confirm('Delete this comment and all replies?')) return;

    $.ajax({
        url: `/comments/${id}`,
        type: 'DELETE',
        data: { _token: "{{ csrf_token() }}" },
        success: function (res) {
            if (res.status) {
                item.remove();
                
                // If backend doesn't return total_count, update locally
                if (res.total_count !== undefined) {
                    setCount(postContainer, res.total_count);
                } else {
                    updateCount(postContainer, -totalToDelete);
                }
            }
        }
    });
});

/* ================= EDIT COMMENT ================= */
$(document).on('click', '.edit-comment', function () {
    let item = $(this).closest('.comment-item');
    item.find('.comment-text, .edit-box').toggleClass('hidden');
});

$(document).on('click', '.save-edit', function () {
    let item = $(this).closest('.comment-item');
    let id = item.data('id');
    let input = item.find('.edit-input');

    $.ajax({
        url: `/comments/${id}`,
        type: 'PUT',
        data: {
            _token: "{{ csrf_token() }}",
            comment: input.val()
        },
        success: function (res) {
            if (res.status) {
                item.find('.comment-text').text(res.comment).removeClass('hidden');
                item.find('.edit-box').addClass('hidden');
            }
        }
    });
});

/* ================= TOGGLE REPLY BOX ================= */
$(document).on('click', '.reply-btn', function () {
    $(this).closest('.comment-item').find('.reply-box').toggleClass('hidden');
});

/* ================= CREATE REPLY ================= */
$(document).on('click', '.send-reply', function () {

    let commentItem = $(this).closest('.comment-item');
    let replyInput = commentItem.find('.reply-input');
    let replyList = commentItem.find('.reply-list');
    let postContainer = commentItem.closest('.bg-white');

    $.post("{{ route('comments.store') }}", {
        _token: "{{ csrf_token() }}",
        post_id: postContainer.find('input[name="post_id"]').val(),
        parent_id: commentItem.data('id'),
        comment: replyInput.val()
    }, function (res) {
        if (res.status) {
            replyList.removeClass('hidden').append(`
                <div class="reply-item bg-white border p-2 rounded text-xs" data-id="${res.data.id}">
                    <div class="flex justify-between">
                        <div>
                            <span class="font-semibold">${res.data.user}</span>
                            · ${res.data.time}
                        </div>
                        <div class="space-x-1">
                            <button class="edit-reply text-blue-600">Edit</button>
                            <button class="delete-reply text-red-600">Delete</button>
                        </div>
                    </div>

                    <p class="reply-text mt-1">${res.data.comment}</p>

                    <div class="reply-edit-box hidden mt-1">
                        <input type="text" class="reply-edit-input w-full border rounded px-2 py-1 text-xs"
                               value="${res.data.comment}">
                        <button class="save-reply-edit text-blue-600 text-xs mt-1">Save</button>
                    </div>
                </div>
            `);

            replyInput.val('');
            commentItem.find('.reply-box').addClass('hidden');

            // toggle replies btn
            let toggleBtn = commentItem.find('.toggle-replies');
            let replyCount = replyList.find('.reply-item').length;

            if (toggleBtn.length) {
                toggleBtn.text(`View ${replyCount} replies`);
            } else {
                commentItem.find('.text-xs.space-x-3').append(
                    `<button class="toggle-replies text-gray-600">View ${replyCount} replies</button>`
                );
            }

            // If backend doesn't return total_count, update locally
            if (res.total_count !== undefined) {
                setCount(postContainer, res.total_count);
            } else {
                updateCount(postContainer, 1);
            }
        }
    });
});

/* ================= EDIT REPLY ================= */
$(document).on('click', '.edit-reply', function () {
    let item = $(this).closest('.reply-item');
    item.find('.reply-text, .reply-edit-box').toggleClass('hidden');
});

$(document).on('click', '.save-reply-edit', function () {
    let item = $(this).closest('.reply-item');
    let id = item.data('id');
    let input = item.find('.reply-edit-input');

    $.ajax({
        url: `/comments/${id}`,
        type: 'PUT',
        data: {
            _token: "{{ csrf_token() }}",
            comment: input.val()
        },
        success: function (res) {
            if (res.status) {
                item.find('.reply-text').text(res.comment).removeClass('hidden');
                item.find('.reply-edit-box').addClass('hidden');
            }
        }
    });
});

/* ================= DELETE REPLY ================= */
$(document).on('click', '.delete-reply', function () {
    let item = $(this).closest('.reply-item');
    let commentItem = item.closest('.comment-item');
    let postContainer = item.closest('.bg-white');

    if (!confirm('Delete reply?')) return;

    $.ajax({
        url: `/comments/${item.data('id')}`,
        type: 'DELETE',
        data: { _token: "{{ csrf_token() }}" },
        success: function (res) {
            if (res.status) {
                item.remove();

                let replyList = commentItem.find('.reply-list');
                let toggleBtn = commentItem.find('.toggle-replies');
                let remain = replyList.find('.reply-item').length;

                if (remain === 0) {
                    toggleBtn.remove();
                    replyList.addClass('hidden');
                } else {
                    toggleBtn.text(`View ${remain} replies`);
                }

                // If backend doesn't return total_count, update locally
                if (res.total_count !== undefined) {
                    setCount(postContainer, res.total_count);
                } else {
                    updateCount(postContainer, -1);
                }
            }
        }
    });
});

/* ================= COLLAPSE REPLIES ================= */
$(document).on('click', '.toggle-replies', function () {
    let replies = $(this).closest('.comment-item').find('.reply-list');
    replies.toggleClass('hidden');

    $(this).text(
        replies.hasClass('hidden') ? 'View replies' : 'Hide replies'
    );
});

/* ================= 3 DOT MENU ================= */
$(document).on('click', '.dots-btn', function (e) {
    e.stopPropagation();
    $('.dots-menu').addClass('hidden');
    $(this).next('.dots-menu').toggleClass('hidden');
});

$(document).click(function () {
    $('.dots-menu').addClass('hidden');
});
</script>
@endpush
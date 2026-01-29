@extends('layouts.admin')

@section('title', "Edit Post Page")
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Edit Post</h2>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="project_id" value="{{ $post->project_id }}">

            <!-- Post Content -->
            <textarea name="content"
                class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-3 outline-none transition"
                rows="4"
                placeholder="Share something with your project...">{{ old('content', $post->content) }}</textarea>

            <!-- Existing Attachments -->
            @if($post->attachments->count() > 0)
            <div class="mb-4">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Existing Attachments</p>
                <div class="space-y-2">
                    @foreach($post->attachments as $attachment)
                    <div class="flex items-center gap-2 text-xs text-gray-600 bg-gray-50 p-2 rounded border border-gray-200"
                        id="attachment-{{ $attachment->id }}">
                        @if($attachment->type === 'image')
                        <i class="fas fa-image text-blue-500"></i>
                        <span class="truncate font-medium flex-1">Image</span>
                        @elseif($attachment->type === 'pdf')
                        <i class="fas fa-file-pdf text-red-500"></i>
                        <span class="truncate font-medium flex-1">PDF Document</span>
                        @elseif($attachment->type === 'link')
                        <i class="fas fa-link text-blue-500"></i>
                        <span class="truncate font-medium flex-1">{{ $attachment->link_url }}</span>
                        @endif

                        <button type="button" class="text-red-500 hover:text-red-700 delete-attachment"
                            data-id="{{ $attachment->id }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Attachment Preview -->
            <div id="attachment-preview" class="mb-3 space-y-1"></div>

            <!-- Footer Actions -->
            <div class="flex justify-between items-center border-t pt-3">

                <div class="flex gap-2">
                    <!-- Image / PDF -->
                    <label
                        class="cursor-pointer bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-sm flex items-center gap-2 transition border border-gray-200">
                        <i class="fas fa-paperclip text-gray-500"></i>
                        <span>Attach More</span>
                        <input type="file" name="attachments[]" multiple hidden accept="image/*,.pdf" id="attachments">
                    </label>

                    <!-- Link -->
                    <button type="button"
                        class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-sm flex items-center gap-2 transition border border-gray-200"
                        id="addLinkBtn">
                        <i class="fas fa-link text-gray-500"></i>
                        <span>Add Link</span>
                    </button>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('posts.index') }}"
                        class="text-gray-500 px-4 py-1.5 text-sm font-medium hover:text-gray-700 transition">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-1.5 rounded-lg text-sm font-semibold transition shadow-sm">
                        Update Post
                    </button>
                </div>
            </div>

            <!-- Link Input -->
            <div class="mt-3 hidden" id="linkBox">
                <input type="url" name="link_url"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    placeholder="Paste link here (https://...)">
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        // Show link input
        $('#addLinkBtn').click(function () {
            $('#linkBox').toggleClass('hidden');
            if (!$('#linkBox').hasClass('hidden')) {
                $('#linkBox input').focus();
            }
        });

        // Attachment preview
        $('#attachments').on('change', function () {
            $('#attachment-preview').html('');

            $.each(this.files, function (i, file) {
                let isImage = file.type.includes('image');
                let icon = isImage ? 'fa-image' : 'fa-file-pdf';
                let color = isImage ? 'text-blue-500' : 'text-red-500';

                $('#attachment-preview').append(`
                    <div class="flex items-center gap-2 text-xs text-gray-600 bg-gray-50 p-2 rounded border border-gray-200 border-dashed">
                        <i class="fas ${icon} ${color}"></i>
                        <span class="truncate font-medium flex-1">${file.name}</span>
                        <span class="text-gray-400">(${(file.size / 1024).toFixed(1)} KB)</span>
                    </div>
                `);
            });
        });

        // Delete individual attachment
        $('.delete-attachment').on('click', function() {
            if(!confirm('Are you sure you want to delete this attachment?')) return;

            let btn = $(this);
            let id = btn.data('id');

            $.ajax({
                url: `/post-attachments/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if(res.success) {
                        $(`#attachment-${id}`).fadeOut(function() {
                            $(this).remove();
                        });
                    }
                }
            });
        });
    });
</script>
@endpush

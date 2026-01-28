@extends('layouts.admin')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-4">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Create New Post</h2>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <!-- Post Content -->
            <textarea name="content"
                class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-3 outline-none transition"
                rows="4"
                placeholder="Share something with your project ({{ $project->title }})..."></textarea>

            <!-- Attachment Preview -->
            <div id="attachment-preview" class="mb-3 space-y-1"></div>

            <!-- Footer Actions -->
            <div class="flex justify-between items-center border-t pt-3">

                <div class="flex gap-2">
                    <!-- Image / PDF -->
                    <label class="cursor-pointer bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-sm flex items-center gap-2 transition border border-gray-200">
                        <i class="fas fa-paperclip text-gray-500"></i>
                        <span>Attach</span>
                        <input type="file" name="attachments[]" multiple hidden accept="image/*,.pdf" id="attachments">
                    </label>

                    <!-- Link -->
                    <button type="button"
                        class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-sm flex items-center gap-2 transition border border-gray-200"
                        id="addLinkBtn">
                        <i class="fas fa-link text-gray-500"></i>
                        <span>Link</span>
                    </button>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-1.5 rounded-lg text-sm font-semibold transition shadow-sm">
                    Post
                </button>
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
    });
</script>
@endpush

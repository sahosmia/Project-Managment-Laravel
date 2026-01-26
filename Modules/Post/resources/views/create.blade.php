@extends('layouts.admin')
@section('content')

<div class="card mb-3">
    <div class="card-body">

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <!-- Post Content -->
            <textarea name="content" class="form-control mb-3" rows="3"
                placeholder="Share something with your project..."></textarea>

            <!-- Attachment Preview -->
            <div id="attachment-preview" class="mb-3"></div>

            <!-- Footer Actions -->
            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex gap-2">
                    <!-- Image / PDF -->
                    <label class="btn btn-light btn-sm mb-0">
                        📎 Attach
                        <input type="file" name="attachments[]" multiple hidden accept="image/*,.pdf" id="attachments">
                    </label>

                    <!-- Link -->
                    <button type="button" class="btn btn-light btn-sm" id="addLinkBtn">
                        🔗 Link
                    </button>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">
                    Post
                </button>
            </div>

            <!-- Link Input -->
            <div class="mt-3 d-none" id="linkBox">
                <input type="url" name="link_url" class="form-control" placeholder="Paste link here...">
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {

    // Show link input
    $('#addLinkBtn').click(function () {
        $('#linkBox').toggleClass('d-none');
    });

    // Attachment preview
    $('#attachments').on('change', function () {
        $('#attachment-preview').html('');

        $.each(this.files, function (i, file) {
            let type = file.type.includes('image') ? '🖼 Image' : '📄 PDF';

            $('#attachment-preview').append(`
                <div class="small text-muted">
                    ${type} - ${file.name}
                </div>
            `);
        });
    });

});
</script>
@endpush

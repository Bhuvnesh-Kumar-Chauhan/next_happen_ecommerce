@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Disclaimer'),
            'headerData' => __('Disclaimer'),
            'url' => $event->id . '/' . preg_replace('/\s+/', '-', $event->name) . '/disclaimer',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Disclaimer') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="ticket-form" action="{{ url('disclaimer/create') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __('Disclaimer') }}</label>
                                            <textarea name="disclaimer" placeholder="{{ __('Disclaimer') }}"
                                                class="form-control summernote @error('disclaimer')? is-invalid @enderror">{{ old('disclaimer') }}</textarea>
                                            @error('disclaimer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                prettifyHtml: true,
                shortcuts: false,
                tabDisable: false
            });
        });
    </script>
    @endpush
@endsection

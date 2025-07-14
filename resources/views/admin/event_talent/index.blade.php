@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Event Talent')])
     <style>
        button, .button-class, .icon-wrapper {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            }
            div, td, span {
            border: none !important;
            }
        .btn-icon {
            border: none; 
            outline: none;  
            background-color: transparent; 
        }
       
    </style>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 mt-2">
                            <div class="col-lg-8">
                                <h2 class="section-title mt-0">{{ __('View Event Talent') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                               <input type="hidden" id="event_id" name="event_id" class="form-control" value="{{ $event->id }}">
                                <a href="{{ url($event->id . '/event-talent-create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add Event Talent') }}
                                </a>

                
                            </div>
                        </div>
                        <div class="table-responsive">
                           <table class="table" id="report_table">
                            <thead>
                                <tr>
                                    <th>{{ __('Talent Category') }}</th>
                                    <th>{{ __('Talent Name') }}</th>
                                    <th>{{ __('Event Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventTalent as $eventTalentItem)
                                    @php
                                        $talent = $talents->find($eventTalentItem->talent_id);
                                        $category = $talent_cat->find($eventTalentItem->talent_category ?? null);
                                    @endphp
                                    @if($talent)
                                        <tr>
                                            <td>{{ $category->name ?? '-' }}</td>
                                            <td>{{ $talent->name }}</td>
                                            <td>{{ $eventTalentItem->event_date ?? '-' }}</td>
                                            <td>
                                                @if($eventTalentItem->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('event-talent.edit', $eventTalentItem->id) }}" class="btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('event-talent.destroy', $eventTalentItem->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this talent?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

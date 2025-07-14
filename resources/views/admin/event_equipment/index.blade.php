@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Event Equipment')])
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
                                <h2 class="section-title mt-0">{{ __('View Event Equipment') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                               <input type="hidden" id="event_id" name="event_id" class="form-control" value="{{ $event->id }}">
                                <a href="{{ url($event->id . '/event-equipment-create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add Event Equipment') }}
                                </a>

                
                            </div>
                        </div>
                        <div class="table-responsive">
                           <table class="table" id="report_table">
                            <thead>
                                <tr>
                                    <th>{{ __('Equipment Type') }}</th>
                                    <th>{{ __('Equipment Name') }}</th>
                                    <th>{{ __('Event Date') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event_equipments as $event_equipmentsItem)
                                    @php
                                        $equipment = $equipments->find($event_equipmentsItem->equipment_id);
                                        $equipment_Types = $equipmentTypes->find($event_equipmentsItem->equipment_type_id ?? null);
                                    @endphp
                                        <tr>
                                            <td>{{ $equipment_Types->name ?? '-' }}</td>
                                            <td>{{ $equipment->name }}</td>
                                            <td>{{ $event_equipmentsItem->event_date ?? '-' }}</td>
                                            <td>{{ $event_equipmentsItem->quantity ?? '-' }}</td>
                                            <td>
                                                @if($event_equipmentsItem->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('event-equipment.edit', $event_equipmentsItem->id) }}" class="btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('event-equipment.destroy', $event_equipmentsItem->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this talent?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                  
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

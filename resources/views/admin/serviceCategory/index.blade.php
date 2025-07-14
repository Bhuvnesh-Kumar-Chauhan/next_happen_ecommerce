@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Services Category'),
    ])
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
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                         
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="container page-alert-container" role="alert">
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 mt-2">
                            <div class="col-lg-8">
                                <h2 class="section-title mt-0">{{ __('View Services Category') }}</h2>
                            </div>
                            <div class="col-lg-4 text-right">
                                  <button class="btn btn-primary add-button">
                                            <a href="{{ route('services.index') }}"> {{ __('Back') }}
                                            </a>
                                        </button>
                                    <button class="btn btn-primary add-button" data-toggle="modal" data-target="#addModal">
                                        <i class="fas fa-plus"></i> {{ __('Add Services Category') }}
                                    </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="report_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($serviceCategories as $category)
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    @if($category->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                  <a href="#" class="btn-icon edit-category" data-toggle="modal" data-target="#editModal" 
                                                        data-id="{{ $category->id }}" 
                                                        data-name="{{ $category->name }}" 
                                                        data-status="{{ $category->is_active }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    <form action="{{ route('services-category.destroy', $category->id)}}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon" onclick="return confirm('Are you sure you want to delete this category?')">
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
 <!-- Add Category Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">{{ __('Add Service Category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('services-category.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="is_active">{{ __('Is Active?') }}</label>
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{{ __('Edit Category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_is_active">{{ __('Is Active?') }}</label>
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Make sure jQuery and Bootstrap JS are loaded before this script
        
        // Edit category modal handler
        $(document).on('click', '.edit-category', function(e) {
            e.preventDefault();
            
            var id = $(this).data('id');
            var name = $(this).data('name');
            var status = $(this).data('status');
            var formAction = "{{ route('services-category.update', ':id') }}".replace(':id', id);
            $('#editForm').attr('action', formAction);
            $('#edit_name').val(name);
            $('#edit_is_active').prop('checked', status == 1);
            
            $('#editModal').modal('show');
        });
      
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var submitButton = form.find('button[type="submit"]');
        
            submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(), 
                 success: function(response) {
                    if (response.success) {
                        // Close modal and cleanup
                        $('#editModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        
                        // Show success message
                        showAlert('success', response.message);
                        
                        // Reload after delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                },
                 error: function(xhr) {
                    // Close modal first
                    $('#editModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    
                    var errorMessage = 'An error occurred';
                    
                    // Handle validation errors
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.name) {
                            errorMessage = xhr.responseJSON.errors.name[0];
                        } else {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                        }
                    } 
                    // Handle duplicate entry
                    else if (xhr.status === 422 && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message.includes('already been taken') 
                            ? 'This category name already exists!' 
                            : xhr.responseJSON.message;
                    }
                    // Other server errors
                    else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    showAlert('danger', errorMessage);
                },
                complete: function() {
                    submitButton.prop('disabled', false).html('Update');
                }
            });
        });
        // Alert display function
        function showAlert(type, message) {
            $('.page-alert-container').html(
                '<div class="alert alert-' + type + ' alert-dismissible fade show">' +
                message +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>'
            );
            
            setTimeout(function() {
                $('.page-alert-container .alert').alert('close');
            }, 5000);
        }
    });
</script>



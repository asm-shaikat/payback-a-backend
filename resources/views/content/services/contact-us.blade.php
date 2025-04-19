@extends('layouts/contentNavbarLayout')

@section('title', 'Services')

@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
<div class="card">
    <h5 class="card-header">Victim's Info</h5>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Scam Info</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody class="table-border-bottom-0">
                @foreach ($services as $service)
                <tr>
                    <td>{{ $service->fname }} {{ $service->lname }}</td>
                    <td>{{ $service->email }}</td>
                    <td>{{ $service->phone }}</td>
                    <td>
                        <span class="badge bg-label-info">{{ $service->scam_type }}</span><br>
                        <span class="badge bg-label-warning">{{ $service->transaction_type }}</span>
                    </td>
                    <td>
                        <div class="d-flex">
                            <!-- View Button -->
                            <button class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewModal"
                                onclick="viewService({{ $service->id }})">
                                <i class="bx bx-show"></i>
                            </button>

                            <!-- Edit Button -->
                            <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModal"
                                onclick="setEditAction('{{ route('services.update', $service->id) }}', {{ $service }})">
                                <i class="bx bx-edit-alt me-1"></i>
                            </button>

                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                onclick="setDeleteAction('{{ route('services.destroy', $service->id) }}')">
                                <i class="bx bx-trash me-1"></i>
                            </button>


                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-3">
        {{ $services->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this service?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editFname" class="form-label">First Name</label>
                        <input type="text" id="editFname" name="fname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editLname" class="form-label">Last Name</label>
                        <input type="text" id="editLname" name="lname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" id="editEmail" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" id="editPhone" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editScamType" class="form-label">Scam Type</label>
                        <input type="text" id="editScamType" name="scam_type" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editTransactionType" class="form-label">Transaction Type</label>
                        <input type="text" id="editTransactionType" name="transaction_type" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Service Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>First Name:</strong> <span id="modalFname"></span></p>
                <p><strong>Last Name:</strong> <span id="modalLname"></span></p>
                <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Scam Type:</strong> <span id="modalScamType"></span></p>
                <p><strong>Transaction Type:</strong> <span id="modalTransactionType"></span></p>
                <p><strong>Scam Amount:</strong> <span id="modalScamAmount"></span></p>
                <p><strong>Scam Description:</strong> <span id="modalScamDescription"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    function setDeleteAction(action) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = action;
    }

    function setEditAction(action, service) {
        const editForm = document.getElementById('editForm');
        editForm.action = action;

        // Populate the form fields
        document.getElementById('editFname').value = service.fname;
        document.getElementById('editLname').value = service.lname;
        document.getElementById('editEmail').value = service.email;
        document.getElementById('editPhone').value = service.phone;
        document.getElementById('editScamType').value = service.scam_type;
        document.getElementById('editTransactionType').value = service.transaction_type;
    }

    function viewService(serviceId) {
        fetch(`/services/${serviceId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalFname').textContent = data.fname;
                document.getElementById('modalLname').textContent = data.lname;
                document.getElementById('modalPhone').textContent = data.phone;
                document.getElementById('modalEmail').textContent = data.email;
                document.getElementById('modalScamType').textContent = data.scam_type;
                document.getElementById('modalTransactionType').textContent = data.transaction_type;
                document.getElementById('modalScamAmount').textContent = data.scam_amount;
                document.getElementById('modalScamDescription').textContent = data.scam_description;
            })
            .catch(error => console.error('Error fetching service data:', error));
    }
</script>
@endsection
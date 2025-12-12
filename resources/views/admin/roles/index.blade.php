@extends('admin.layouts.admin')

@section('title', 'Admin Users & Roles')

@section('content')
    <div class="d-flex justify-content-end align-items-center py-2">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="bi bi-person-plus"></i>
            </button>
            <button class="btn btn-sm btn-gradient-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="bi bi-shield-plus"></i> Add Role
            </button>
        </div>
    </div>
    <div class="row g-4">
        {{-- LEFT: ADMIN USERS TABLE --}}
        <div class="col-lg-8">
            <section class="h-100">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100">
                    <div
                        class="card-header bg-gradient-light py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold text-primary mb-0">
                            <i class="bi bi-person-gear me-2"></i> Admin Users
                        </h5>
                        <span class="badge bg-gradient-primary text-white px-3 py-2">
                            {{ $adminUsers->count() }} total
                        </span>
                    </div>

                    <div class="card-body p-0">
                        @if ($adminUsers->isEmpty())
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-emoji-frown fs-3 d-block mb-2"></i>
                                No admin users found.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($adminUsers as $user)
                                            <tr class="hover-row">
                                                <td class="fw-semibold">{{ $user->name }}</td>
                                                <td class="text-muted">{{ $user->email }}</td>

                                                {{-- ROLE COLUMN --}}
                                                <td>
                                                    @if ($user->role)
                                                        <span class="badge bg-gradient-primary text-white">
                                                            <i class="bi bi-shield-lock me-1"></i>{{ $user->role->name }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">No Role</span>
                                                    @endif
                                                </td>

                                                {{-- STATUS COLUMN --}}
                                                <td>
                                                    @if ($user->is_active)
                                                        <span class="badge bg-gradient-success">Active</span>
                                                    @else
                                                        <span class="badge bg-gradient-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                {{-- ACTIONS COLUMN --}}
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2 align-items-center">

                                                        {{-- INLINE ROLE DROPDOWN --}}
                                                        <form method="POST" action="{{ route('admin.roles.assign') }}"
                                                            class="role-assign-form">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <input type="hidden" name="role_id">

                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-glow-primary dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi bi-shield-lock-fill"></i>
                                                                    {{ $user->role ? 'Change Role' : 'Assign Role' }}
                                                                </button>

                                                                <ul class="dropdown-menu shadow-sm p-2">
                                                                    <li>
                                                                        <button type="button" data-role=""
                                                                            class="dropdown-item text-danger small open-confirm">
                                                                            <i class="bi bi-x-circle me-1"></i> Choose Role (Revoke)
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <hr class="dropdown-divider">
                                                                    </li>

                                                                    @foreach ($roles as $role)
                                                                        <li>
                                                                            <button type="button" data-role="{{ $role->id}}"
                                                                                class="dropdown-item small open-confirm {{ $user->role && $user->role->id == $role->id ? 'active' : '' }}">
                                                                                <i class="bi bi-shield-fill me-1"></i>
                                                                                {{ $role->name }}
                                                                            </button>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </form>
                                                        <div class="modal fade" id="confirmRoleModal" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div
                                                                    class="modal-content bg-[linear-gradient(45deg,#007bff,#00c6ff)] shadow">
                                                                    <div class="modal-header bg-warning">
                                                                        <h5 class="modal-title">Confirm Role Change</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        Are you sure you want to change this user’s role?
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            id="confirmRoleBtn">Yes, Change</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        {{-- EDIT USER --}}
                                                        <button class="btn btn-sm btn-glow-secondary" data-bs-toggle="modal"
                                                            data-bs-target="#userModal" data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}"
                                                            data-user-phone="{{ $user->phone ?? '' }}">
                                                            <i class="bi bi-pencil-fill"></i> Edit
                                                        </button>

                                                        {{-- DELETE --}}
                                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                                            class="d-inline delete-form">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-glow-danger">
                                                                <i class="bi bi-trash3-fill"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        {{-- RIGHT: ROLES OVERVIEW --}}
        <div class="col-lg-4">
            <section class="h-100">
                <div class="card shadow-sm border-0 rounded-4 h-100 d-flex flex-column">
                    <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0 text-primary">
                            <i class="bi bi-diagram-3-fill me-2"></i> Roles Overview
                        </h5>
                        <span class="badge bg-gradient-primary text-white px-3 py-2">
                            {{ $roles->count() }} total
                        </span>
                    </div>
                    <div class="card-body overflow-auto" style="max-height: 540px;">
                        <div class="row g-3">
                            @foreach ($roles as $role)
                                <div class="col-12">
                                    <div class="card role-card shadow-sm border-0 rounded-4 p-3 h-100 hover-glow">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">{{ $role->name }}</h6>
                                                <p class="small text-muted mb-2">
                                                    {{ $role->description ?? 'No description' }}
                                                </p>
                                                <span class="badge bg-gradient-primary text-white px-3 py-2">
                                                    <i class="bi bi-people me-1"></i> {{ $role->admin_users_count }} users
                                                </span>
                                            </div>
                                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                class="btn btn-light btn-sm rounded-circle shadow-sm edit-btn"
                                                title="Edit Role">
                                                <i class="bi bi-pencil-square text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($roles->isEmpty())
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-shield-slash fs-4 d-block mb-2"></i>
                                    No roles defined yet.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    {{-- ✅ ADD / EDIT ADMIN USER MODAL --}}
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.users.store') }}"
                class="modal-content shadow-lg border-0 rounded-4 p-2" id="userForm">
                @csrf
                <input type="hidden" name="_method" id="userFormMethod" value="POST">
                <input type="hidden" name="user_id" id="userIdField" value="{{ old('user_id', '') }}">

                <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                    <h5 class="modal-title" id="userModalTitle">
                        <i class="bi bi-person-plus me-1"></i> Add New Admin
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" id="userName" class="form-control" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="userEmail" class="form-control" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" id="userPhone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 password-field">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" id="userPassword" class="form-control" {{ old('_method') === 'PUT' ? '' : 'required' }}> @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-gradient-primary" type="submit" id="userSubmitBtn">
                        <i class="bi bi-check-circle me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ ADD ROLE MODAL --}}
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.roles.store') }}"
                class="modal-content shadow-lg border-0 rounded-4 p-2">
                @csrf
                <div class="modal-header bg-gradient-success text-white rounded-top-4">
                    <h5 class="modal-title"><i class="bi bi-shield-plus me-1"></i> Add Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Manager">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-gradient-success" type="submit">
                        <i class="bi bi-plus-circle me-1"></i> Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/setting-role.css') }}">
    @endpush

    @push('scripts')
        <script>
            // ✅ Single Add/Edit Modal Logic
            // const userModal = document.getElementById('userModal');
            // userModal.addEventListener('show.bs.modal', e => {
            //     const btn = e.relatedTarget;
            //     const form = document.getElementById('userForm');
            //     const title = document.getElementById('userModalTitle');
            //     const method = document.getElementById('userFormMethod');
            //     const passwordField = document.querySelector('.password-field');

            //     if (btn.dataset.userId) {
            //         // Edit Mode
            //         form.action = "{{ url('admin/users') }}/" + btn.dataset.userId;
            //         title.innerHTML = `<i class="bi bi-pencil-square me-1"></i> Edit Admin`;
            //         method.value = 'PUT';
            //         passwordField.style.display = 'none';
            //         document.getElementById('userName').value = btn.dataset.userName;
            //         document.getElementById('userEmail').value = btn.dataset.userEmail;
            //         document.getElementById('userPhone').value = btn.dataset.userPhone;
            //     } else {
            //         // Add Mode
            //         form.action = "{{ route('admin.users.store') }}";
            //         title.innerHTML = `<i class="bi bi-person-plus me-1"></i> Add New Admin`;
            //         method.value = 'POST';
            //         passwordField.style.display = 'block';
            //         form.reset();
            //     }
            // });

            // ✅ Single Add/Edit Modal Logic (modified)
            const userModal = document.getElementById('userModal');
            userModal.addEventListener('show.bs.modal', e => {
                const btn = e.relatedTarget;
                const form = document.getElementById('userForm');
                const title = document.getElementById('userModalTitle');
                const method = document.getElementById('userFormMethod');
                const passwordField = document.querySelector('.password-field');
                const userIdField = document.getElementById('userIdField');

                if (btn && btn.dataset.userId) {
                    // Edit Mode
                    form.action = "{{ url('admin/users') }}/" + btn.dataset.userId;
                    title.innerHTML = `<i class="bi bi-pencil-square me-1"></i> Edit Admin`;
                    method.value = 'PUT';
                    passwordField.style.display = 'none';

                    // fill fields from data-* attributes (from the edit button)
                    document.getElementById('userName').value = btn.dataset.userName || '';
                    document.getElementById('userEmail').value = btn.dataset.userEmail || '';
                    document.getElementById('userPhone').value = btn.dataset.userPhone || '';

                    // ensure hidden user_id is set (so it remains after validation redirect)
                    userIdField.value = btn.dataset.userId;
                } else {
                    // Add Mode
                    form.action = "{{ route('admin.users.store') }}";
                    title.innerHTML = `<i class="bi bi-person-plus me-1"></i> Add New Admin`;
                    method.value = 'POST';
                    passwordField.style.display = 'block';
                    form.reset();

                    // clear hidden user id (add mode)
                    userIdField.value = '';
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                @if ($errors->any())
                    // there were validation errors — reopen modal and populate fields with old() values
                    (function () {
                        const form = document.getElementById('userForm');
                        const method = document.getElementById('userFormMethod');
                        const passwordField = document.querySelector('.password-field');
                        const userId = "{{ old('user_id', '') }}";
                        const oldMethod = "{{ old('_method', 'POST') }}";

                        // Set form action/mode depending on whether old user_id exists
                        if (oldMethod === 'PUT' && userId) {
                            form.action = "{{ url('admin/users') }}/" + userId;
                            method.value = 'PUT';
                            passwordField.style.display = 'none';
                            document.getElementById('userName').value = "{{ addslashes(old('name')) }}";
                            document.getElementById('userEmail').value = "{{ addslashes(old('email')) }}";
                            document.getElementById('userPhone').value = "{{ addslashes(old('phone')) }}";
                            document.getElementById('userIdField').value = userId;
                            document.getElementById('userModalTitle').innerHTML = `<i class="bi bi-pencil-square me-1"></i> Edit Admin`;
                        } else {
                            // Add mode or first-time submit
                            form.action = "{{ route('admin.users.store') }}";
                            method.value = 'POST';
                            passwordField.style.display = 'block';
                            document.getElementById('userName').value = "{{ addslashes(old('name')) }}";
                            document.getElementById('userEmail').value = "{{ addslashes(old('email')) }}";
                            document.getElementById('userPhone').value = "{{ addslashes(old('phone')) }}";
                            document.getElementById('userIdField').value = '';
                            document.getElementById('userModalTitle').innerHTML = `<i class="bi bi-person-plus me-1"></i> Add New Admin`;
                        }

                        // show the modal
                        const modalEl = document.getElementById('userModal');
                        const bsModal = new bootstrap.Modal(modalEl);
                        bsModal.show();
                    })();
                @endif
                                                                    });


            // ✅ Loader disable logic
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn && !btn.disabled) {
                        btn.disabled = true;
                        const spinner = document.createElement('span');
                        spinner.className = "spinner-border spinner-border-sm me-2";
                        spinner.role = "status";
                        spinner.ariaHidden = "true";
                        btn.prepend(spinner);
                    }
                });
            });

            // ✅ Confirm delete
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', e => {
                    if (!confirm('Are you sure you want to delete this user?')) e.preventDefault();
                });
            });


            //Change Role
            document.addEventListener("DOMContentLoaded", function () {

                let selectedRole = null;
                let form = null;

                document.querySelectorAll(".open-confirm").forEach(btn => {
                    btn.addEventListener("click", function () {
                        selectedRole = this.getAttribute("data-role");
                        form = this.closest("form");

                        new bootstrap.Modal(document.getElementById("confirmRoleModal")).show();
                    });
                });

                document.getElementById("confirmRoleBtn").addEventListener("click", function () {
                    if (form) {
                        form.querySelector("input[name='role_id']").value = selectedRole;
                        form.submit();
                    }
                });

            });


        </script>
    @endpush
@endsection
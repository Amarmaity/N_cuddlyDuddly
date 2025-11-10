@extends('admin.layouts.admin')

@section('title', 'Customer Support Tickets')

@section('content')
    <div class="container-fluid py-3">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">🧍 Customer Support Tickets</h5>
        </div>
        {{-- 🔎 Filter Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.support.customer') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="By Ticket ID, Subject, Customer Name, or Order ID">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            @foreach(['open' => 'Open', 'pending' => 'Pending', 'closed' => 'Closed', 'reopened' => 'Reopened'] as $key => $label)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="">All</option>
                            @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $key => $label)
                                <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                    {{ ucfirst($label) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- 🎟️ Support Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ticket ID</th>
                            <th>Customer</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Opened On</th>
                            <th>Last Updated</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supports as $support)
                                        <tr>
                                            <td><span class="fw-semibold text-primary">{{ $support->ticket_id }}</span></td>
                                            <td>
                                                {{ ($support->customer->first_name ?? 'Guest') . ' ' . ($support->customer->last_name ?? '') }}
                                            </td>
                                            <td class="text-truncate" style="max-width: 250px;">{{ $support->subject }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ 
                                                                                                                                                                                                    $support->status === 'open' ? 'success' :
                            ($support->status === 'pending' ? 'warning text-dark' :
                                ($support->status === 'closed' ? 'secondary' : 'info'))
                                                                                                                                                                                                }}">
                                                    {{ ucfirst($support->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ 
                                                                                                                                                                                                    $support->priority === 'high' ? 'danger' :
                            ($support->priority === 'medium' ? 'warning text-dark' : 'secondary')
                                                                                                                                                                                                }}">
                                                    {{ ucfirst($support->priority) }}
                                                </span>
                                            </td>
                                            <td>{{ $support->created_at->format('d M Y, h:i A') }}</td>
                                            <td>{{ $support->updated_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary view-btn"
                                                    data-support="{{ $support->toJson() }}">
                                                    <i class="bi bi-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No support tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($supports instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer bg-white">
                    {{ $supports->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
    <!-- 💬 Customer Support Chat Modal -->
    <div class="modal fade" id="viewSupportModal" tabindex="-1" aria-labelledby="viewSupportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-chat-dots me-2"></i> Customer Support Chat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body bg-light">
                    <!-- 🧾 Ticket Info -->
                    <div class="p-3 bg-white rounded shadow-sm mb-3">
                        <div class="row">
                            <div class="col-md-4"><strong>Ticket ID:</strong> <span id="supportTicket"></span></div>
                            <div class="col-md-4"><strong>Status:</strong> <span id="supportStatus"></span></div>
                            <div class="col-md-4"><strong>Priority:</strong> <span id="supportPriority"></span></div>
                        </div>
                    </div>

                    <!-- 💬 Message List -->
                    <div id="chatBox" class="bg-white border rounded p-3 mb-3"
                        style="height: 400px; overflow-y: auto; background: #f9fafb;">
                        <p class="text-center text-muted my-5">Loading messages...</p>
                    </div>

                    <!-- 💬 Message Form -->
                    <form id="messageForm" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                        <input type="hidden" id="supportId">
                        <input id="messageInput" type="hidden" name="message">

                        <trix-editor input="messageInput" class="trix-content border rounded p-2 bg-white"
                            placeholder="Type your message or attach files..."></trix-editor>

                        <!-- Attachment previews (outside Trix) -->
                        <div id="attachmentPreviewArea" class="d-flex flex-wrap gap-2 mt-1"></div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <label class="fw-semibold me-2 mb-0">Status:</label>
                                <button type="button" class="btn btn-outline-success status-btn" data-status="open">
                                    <i class="bi bi-unlock"></i> Open
                                </button>
                                <button type="button" class="btn btn-outline-warning status-btn" data-status="pending">
                                    <i class="bi bi-hourglass-split"></i> Pending
                                </button>
                                <button type="button" class="btn btn-outline-secondary status-btn" data-status="closed">
                                    <i class="bi bi-lock-fill"></i> Closed
                                </button>
                                <button type="button" class="btn btn-outline-info status-btn" data-status="reopened">
                                    <i class="bi bi-arrow-repeat"></i> Reopen
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Send
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = new bootstrap.Modal(document.getElementById('viewSupportModal'));
            const chatBox = document.getElementById('chatBox');
            const form = document.getElementById('messageForm');
            const attachmentPreview = document.getElementById('attachmentPreviewArea');
            let currentSupportId = null;
            let currentStatus = null;
            let attachedFiles = [];

            // 🟢 Open modal and load chat
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const support = JSON.parse(btn.dataset.support);
                    currentSupportId = support.id;
                    currentStatus = support.status;

                    document.getElementById('supportTicket').textContent = support.ticket_id;
                    document.getElementById('supportStatus').textContent = support.status;
                    document.getElementById('supportPriority').textContent = support.priority;

                    loadMessages(currentSupportId);
                    modal.show();
                });
            });

            // 🟡 Handle Trix attachments (prevent inline preview)
            document.addEventListener('trix-file-accept', event => {
                event.preventDefault(); // prevent Trix from inserting inline
                const file = event.file;
                attachedFiles.push(file);

                const fileId = crypto.randomUUID();
                const fileDiv = document.createElement('div');
                fileDiv.className = 'badge bg-light border text-dark d-flex align-items-center gap-2 p-2';
                fileDiv.innerHTML = `
                            <i class="bi bi-paperclip"></i>
                            <span>${file.name}</span>
                            <button type="button" class="btn-close btn-sm" data-id="${fileId}"></button>
                        `;
                fileDiv.querySelector('.btn-close').onclick = () => {
                    attachedFiles = attachedFiles.filter(f => f.name !== file.name);
                    fileDiv.remove();
                };
                attachmentPreview.appendChild(fileDiv);
            });

            // 🔵 Send message (text + files)
            form.addEventListener('submit', async e => {
                e.preventDefault();
                const message = document.querySelector('#messageInput').value.trim();
                if (!message && attachedFiles.length === 0) return;

                const formData = new FormData();
                formData.append('message', message);
                formData.append('status', currentStatus);
                attachedFiles.forEach(f => formData.append('attachments[]', f));

                const res = await fetch(`/admin/customer-supports/${currentSupportId}/messages`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: formData
                });

                if (res.ok) {
                    document.querySelector('trix-editor').value = '';
                    document.querySelector('#messageInput').value = '';
                    attachmentPreview.innerHTML = '';
                    attachedFiles = [];
                    loadMessages(currentSupportId);
                }
            });

            // 🔴 Status button change
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    currentStatus = btn.dataset.status;
                    document.getElementById('supportStatus').textContent = currentStatus;

                    await fetch(`/admin/customer-supports/${currentSupportId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ status: currentStatus })
                    });
                });
            });

            // 💬 Load chat messages
            async function loadMessages(supportId) {
                chatBox.innerHTML = `<p class="text-center text-muted my-5">Loading messages...</p>`;
                const res = await fetch(`customer/${supportId}/messages`);
                const data = await res.json();

                chatBox.innerHTML = '';
                if (!data.messages?.length) {
                    chatBox.innerHTML = `<p class="text-center text-muted my-5">No messages yet.</p>`;
                    return;
                }

                data.messages.forEach(msg => {
                    const isAdmin = msg.sender_type === 'admin';
                    const bubble = `
                    <div class="d-flex ${isAdmin ? 'justify-content-end' : 'justify-content-start'} mb-2">
                        <div class="p-2 rounded-3 ${isAdmin ? 'bg-primary-subtle text-dark border border-primary' : 'bg-light border'}" style="max-width: 75%;">
                            ${msg.message}
                            ${msg.attachments ? renderAttachments(msg.attachments) : ''}
                        </div>
                    </div>`;

                    chatBox.insertAdjacentHTML('beforeend', bubble);
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            function renderAttachments(attachments) {
                try {
                    const files = JSON.parse(attachments);
                    return files.map(file => `
                                <div class="mt-2">
                                    <a href="/storage/${file}" target="_blank" class="text-decoration-none ${file.endsWith('.jpg') || file.endsWith('.png') ? 'd-block' : ''}">
                                        <i class="bi bi-paperclip"></i> ${file.split('/').pop()}
                                    </a>
                                </div>`).join('');
                } catch {
                    return '';
                }
            }
        });
    </script>
@endpush
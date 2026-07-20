<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Alert Notifikasi -->
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4"
                    role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4"
                    role="alert" style="background-color: #f8d7da; color: #842029;">
                    <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Card Utama -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Header Card Modern -->
                <div
                    class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark d-flex align-items-center" style="color: #0A3622 !important;">
                            <i class="fa-solid fa-users-gear me-2 text-[#FFC107]"></i> Manajemen Pengguna Aplikasi
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">Kelola data login petugas Kepaniteraan Hukum
                            PN Kaimana.</p>
                    </div>

                    <!-- Tombol Tambah Data -->
                    <button wire:click="resetFields" data-bs-toggle="modal" data-bs-target="#userFormModal"
                        class="btn btn-success ...">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah Pengguna Baru
                    </button>
                </div>

                <!-- Bagian Kontrol Pencarian yang Dipercantik -->
                <div class="card-body bg-light/50 border-bottom border-top py-3 px-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-white border-end-0 text-muted px-3">
                                    <i class="bi bi-search" style="font-size: 13px;"></i>
                                </span>
                                <input wire:model.live="search" type="text" class="form-control border-start-0 ps-0"
                                    style="font-size: 13px; focus:ring-0;"
                                    placeholder="Cari nama, username, atau role...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data yang Sudah Diperbaiki & Dipercantik -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase text-secondary"
                            style="font-size: 11px; letter-spacing: 0.8px; border-bottom: 2px solid #f1f1f1;">
                            <tr>
                                <th class="ps-4 py-3 text-center" style="width: 70px;">No</th>
                                <th class="py-3">Nama Lengkap</th>
                                <th class="py-3">Username</th>
                                <th class="py-3">Hak Akses / Role</th>
                                <th class="pe-4 py-3 text-end" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr style="transition: all 0.2s ease;">
                                    <td class="ps-4 text-center fw-medium text-muted" style="font-size: 13px;">
                                        {{ $users->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Avatar Inisial yang Elegan -->
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                                style="background: linear-gradient(135deg, #146C43 0%, #0A3622 100%); width: 36px; height: 36px; font-size: 12px; letter-spacing: 0.5px;">
                                                {{ strtoupper(substr($user->username, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block mb-0"
                                                    style="font-size: 14px;">{{ $user->nama_lengkap }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1.5 font-monospace"
                                            style="font-size: 12px;">
                                            @ {{ $user->username }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($user->role === 'Admin')
                                            <span
                                                class="badge bg-danger-subtle text-danger px-2.5 py-1.5 text-uppercase fw-bold"
                                                style="font-size: 10px; border: 1px solid rgba(220, 53, 69, 0.2);">
                                                <i class="bi bi-shield-lock-fill me-1"></i> {{ $user->role }}
                                            </span>
                                        @elseif($user->role === 'Posbakum')
                                            <span
                                                class="badge bg-info-subtle text-info-emphasis px-2.5 py-1.5 text-uppercase fw-bold"
                                                style="font-size: 10px; border: 1px solid rgba(13, 202, 240, 0.3);">
                                                <i class="bi bi-file-earmark-text-fill me-1"></i> {{ $user->role }}
                                            </span>
                                        @elseif($user->role === 'Petugas PTSP')
                                            <span
                                                class="badge bg-warning-subtle text-warning-emphasis px-2.5 py-1.5 text-uppercase fw-bold"
                                                style="font-size: 10px; border: 1px solid rgba(255, 193, 7, 0.3);">
                                                <i class="bi bi-person-badge-fill me-1"></i> {{ $user->role }}
                                            </span>
                                        @elseif($user->role === 'Petugas Back Office')
                                            <span
                                                class="badge bg-primary-subtle text-primary px-2.5 py-1.5 text-uppercase fw-bold"
                                                style="font-size: 10px; border: 1px solid rgba(13, 110, 253, 0.2);">
                                                <i class="bi bi-laptop-fill me-1"></i> {{ $user->role }}
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 text-uppercase fw-bold"
                                                style="font-size: 10px;">
                                                <i class="bi bi-person-fill me-1"></i> {{ $user->role }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <!-- Tombol Edit (Instan Buka Modal + Load Data) -->
                                        <button wire:click="edit({{ $user->id }})" data-bs-toggle="modal"
                                            data-bs-target="#userFormModal"
                                            class="btn btn-sm btn-light text-warning border-0 rounded-3 me-1 px-2 py-1.5 shadow-sm hover:bg-warning-subtle"
                                            title="Ubah Data" style="transition: all 0.2s;">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Hapus dengan Konfirmasi SweetAlert2 -->
                                        <button
                                            onclick="confirmDelete({{ $user->id }}, '{{ $user->nama_lengkap }}')"
                                            class="btn btn-sm btn-light text-danger border-0 rounded-3 px-2 py-1.5 shadow-sm hover:bg-danger-subtle"
                                            title="Hapus Data" style="transition: all 0.2s;">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users-slash d-block fs-2 mb-3 text-muted/40"></i>
                                        <span class="fw-medium" style="font-size: 14px;">Data pengguna tidak ditemukan
                                            atau tabel kosong.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Bootstrap -->
                <div class="card-footer bg-white border-0 py-3 px-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <span class="text-muted" style="font-size: 12px;">Menampilkan {{ $users->firstItem() ?? 0 }}
                            sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data.</span>
                        <div class="pagination-sm">{{ $users->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL POPUP FORM (BOOTSTRAP 5) -->
    <div wire:ignore.self class="modal fade" id="userFormModal" tabindex="-1" aria-labelledby="userFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="userFormModalLabel" style="color: #0A3622;">
                        {{ $isEditMode ? 'Ubah Data Pengguna' : 'Tambah Pengguna Baru' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body p-4">
                        <!-- Input Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted text-uppercase" style="font-size: 11px;">Nama
                                Lengkap</label>
                            <input wire:model="nama_lengkap" type="text"
                                class="form-control rounded-3 py-2 @error('nama_lengkap') is-invalid @enderror"
                                placeholder="Contoh: John Doe">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Username -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted text-uppercase"
                                style="font-size: 11px;">Username Login</label>
                            <input wire:model="username" type="text"
                                class="form-control rounded-3 py-2 @error('username') is-invalid @enderror"
                                placeholder="Contoh: johndoe">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Opsi Pilihan Role -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted text-uppercase" style="font-size: 11px;">
                                Hak Akses / Role
                            </label>
                            <select wire:model="role"
                                class="form-select rounded-3 py-2 @error('role') is-invalid @enderror">
                                <option value="">-- Pilih Hak Akses --</option>
                                <option value="Admin">Admin</option>
                                <option value="Posbakum">Posbakum</option>
                                <option value="Petugas PTSP">Petugas PTSP</option>
                                <option value="Petugas Back Office">Petugas Back Office</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="mb-2">
                            <label class="form-label fw-bold text-muted text-uppercase"
                                style="font-size: 11px;">Password</label>
                            <input wire:model="password" type="password"
                                class="form-control rounded-3 py-2 @error('password') is-invalid @enderror"
                                placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($isEditMode)
                                <small class="text-muted d-block mt-1" style="font-size: 11px; font-style: italic;">*
                                    Kosongkan kolom password jika tidak ingin menggantinya.</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-3 px-4 py-2 text-muted fw-semibold"
                            data-bs-dismiss="modal" wire:click="resetFields">Batal</button>

                        <!-- Tombol Submit dengan State Loading Bawaan -->
                        <button type="submit"
                            class="btn btn-success rounded-3 px-4 py-2 fw-semibold border-0 shadow-sm"
                            style="background-color: #0A3622;">
                            <span wire:loading.remove><i class="fa-solid fa-circle-check me-1"></i> Simpan</span>
                            <span wire:loading><span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span> Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT EVENT TRIGGER UNTUK MODAL BOOTSTRAP 5 -->
    <script>
        document.addEventListener('livewire:init', () => {
            const bootstrapModal = new bootstrap.Modal(document.getElementById('userFormModal'));

            Livewire.on('openModal', () => {
                bootstrapModal.show();
            });

            Livewire.on('closeModal', () => {
                bootstrapModal.hide();
            });
        });
    </script>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Memanggil method destroy() pada komponen Livewire
                    @this.call('destroy', id);
                }
            });
        }
    </script>
</div>

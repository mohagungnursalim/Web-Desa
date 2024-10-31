<div class="py-4">
    @push('styles')
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
                <!-- Tombol untuk membuka modal -->
                <button style="border-radius: 10px;" id="openModalBtn"
                    class="btn btn-primary mb-4 d-block d-md-inline-block">Tambah Akun</button>


                <!-- Input untuk mencari tag -->
                <div class="mb-2">
                    <input style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari akun.." class="form-control" style="color: black;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Ditambahkan</th>
                            <th>Diperbarui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <div class="image">
                                    <img src="{{ asset('storage/' . ($user->image ?? 'default.png')) }}" width="30px" class="img-circle elevation-2" alt="{{ $user->name }}">
                                  </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->first()->name ?? 'No Role' }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                <!-- Tombol untuk membuka modal update -->
                                <button style="border-radius: 10px;" wire:click="openUpdateModal({{ $user->id }})"
                                    class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Tombol untuk membuka modal delete -->
                                <button style="border-radius: 10px;" data-toggle="modal"
                                    data-target="#modalDelete{{ $user->id }}" type="button"
                                    class="btn btn-danger text-white">
                                    <i class="bi bi-trash3"></i>
                                </button> 
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada akun yang ditemukan.</td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>


    {{-- ----------------Modal------------------------ --}}


    <!-- Modal Tambah Akun -->
    <div id="addUserModal" class="modal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" placeholder="Masukan nama pengguna.." class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" placeholder="Masukan email pengguna.." class="form-control" id="email" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" class="form-control" wire:model="role">
                                <option value="">-Pilih Role-</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="password">Password Default</label>
                            <input disabled type="text" placeholder="12345678" class="form-control">
                        </div>
                    
                    
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:loading.remove wire:target="createUser">Tutup</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                        wire:click="createUser">Simpan</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                        wire:target="createUser">
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
    


     <!-- Modal Edit Akun -->
     <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" placeholder="Masukan nama pengguna.." class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" placeholder="Masukan email pengguna.." class="form-control" id="email" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" class="form-control" wire:model="role">
                                <option value="">-Pilih Role-</option>
                                @foreach($roles as $roleOption)
                                    <option value="{{ $roleOption->id }}">{{ $roleOption->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>    
                    
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:loading.remove wire:target="updateUser">Tutup</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                        wire:click="updateUser">Simpan</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                        wire:target="updateUser">
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>



    {{-- Modal Delete --}}
    @foreach ($users as $user)

    <div class="modal" id="modalDelete{{ $user->id }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                        Hapus Akun "{{ $user->name }}" </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus akun ini?
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" wire:loading.remove wire:target='deleteUser({{ $user->id }})'
                        type="button" class="btn btn-secondary" data-dismiss="modal">Batal
                    </button>
                    <button style="border-radius: 10px;" wire:loading.remove wire:click="deleteUser({{ $user->id }})"
                        type="button" class="btn btn-danger">Hapus
                    </button>

                    <button style="border-radius: 10px;" wire:loading wire:target='deleteUser({{ $user->id }})'
                        class="btn btn-danger" disabled>
                        Menghapus <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endforeach

    @push('scripts')

    {{-- Modal Open --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
        $(document).ready(function () {
            // Membuka modal ketika tombol ditekan
            $('#openModalBtn').click(function () {
                $('#addUserModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeAddUserModal', function (event) {
                $('#addUserModal').modal('hide'); // Menutup modal
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Reset form di backend setelah modal ditutup
            $('#addUserModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Jika modal ditutup, hapus backdrop jika ada
            $('#addUserModal').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Hapus backdrop
            });
        });
    });

    </script>

{{-- Edit Modal --}}
<script>
    $(document).ready(function () {
        
        // Membuka modal Edit
        window.addEventListener('openEditUserModal', function () {
            $('#editUserModal').modal('show');
        });

        // Mendengarkan event dari Livewire untuk menutup modal
        window.addEventListener('closeUpdatedModal', function () {
            $('#editUserModal').modal('hide'); // Menutup modal
            
            // Menghapus backdrop ketika modal ditutup
            $('#editUserModal').on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open'); // Hilangkan kelas modal-open pada body
                $('.modal-backdrop').remove(); // Hapus modal-backdrop
            });
        });

        // Reset form di backend setelah modal ditutup
        $('#editUserModal').on('hidden.bs.modal', function () {
            @this.call('resetForm'); // Memanggil fungsi resetForm di Component
        });
    });
</script>

    {{-- Sweet alert,added success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('closeAddUserModal', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "User berhasil ditambahkan!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>
    {{-- Sweet alert,Updated success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('closeUpdatedModal', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Akun berhasil diperbarui!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Hide Modal Delete --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('hideModalDelete', function (event) {
                var modalId = event.detail;

                if (Array.isArray(modalId)) {
                    modalId = modalId[0];
                }

                if (typeof modalId === 'string' && modalId.trim() !== '') {
                    var $modal = $('#' + modalId);

                    // Menutup modal
                    $modal.modal('hide');

                    // Fungsi untuk membersihkan modal dan backdrop
                    function cleanupModal() {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $modal.removeClass('show');
                        $modal.css('display', 'none');
                        $('body').css('overflow', '');
                        $('body').css('padding-right', '');
                    }

                    // Mencoba membersihkan setelah animasi modal selesai
                    $modal.on('hidden.bs.modal', cleanupModal);

                    // Backup: jika event tidak terpicu, bersihkan setelah delay
                    setTimeout(cleanupModal, 500);
                } else {
                    console.error('Invalid modal ID:', modalId);
                }
            });
        });

    </script>

    {{-- Sweet alert,delete success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Tag berhasil dihapus!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Sweet alert,delete gagal --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteError', function (event) {
                Swal.fire({
                    title: "Oops!",
                    text: "Tag gagal dihapus!",
                    icon: "error",
                    timer: 1500,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    @endpush
</div>

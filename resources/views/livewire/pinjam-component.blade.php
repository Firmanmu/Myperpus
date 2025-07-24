<div>
  <div class="card">
    <div class="card-header">
      Pinjam Buku
    </div>
    <div class="card-body">
      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Buku</th>
              <th>Member</th>
              <th>Tanggal Pinjam</th>
              <th>Tanggal Kembali</th>
              <th>Status</th>
              <th>Proses</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pinjam as $data)
              <tr>
                <td>{{ $loop->iteration + $pinjam->firstItem() - 1 }}</td>
                <td>{{ $data->buku?->judul }}</td>
                <td>{{ $data->user?->nama }}</td>
                <td>{{ $data->tgl_pinjam }}</td>
                <td>{{ $data->tgl_kembali }}</td>
                <td>{{ $data->status }}</td>
                <td>
                  <button wire:click="edit({{ $data->id }})" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editPage">Edit</button>
                  <button wire:click="confirm({{ $data->id }})" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePage">Hapus</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{ $pinjam->links() }}
      </div>

      <button class="btn btn-primary" data-toggle="modal" data-target="#addPage">Tambah</button>
    </div>
  </div>

  <!-- Modal Tambah -->
  <div wire:ignore.self class="modal fade" id="addPage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pinjam Buku</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label>Judul Buku</label>
              <select wire:model="buku" class="form-control">
                <option value="">--pilih--</option>
                @foreach($book as $data)
                  <option value="{{ $data->id }}">{{ $data->judul }}</option>
                @endforeach
              </select>
              @error('buku') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
              <label>Member</label>
              <select wire:model="user" class="form-control">
                <option value="">--pilih--</option>
                @foreach($member as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              @error('user') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button wire:click="store" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div wire:ignore.self class="modal fade" id="editPage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Pinjam Buku</h5>
          <button class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
            <div class="form-group">
              <label>Judul Buku</label>
              <select wire:model="buku" class="form-control">
                <option value="">--pilih--</option>
                @foreach($book as $data)
                  <option value="{{ $data->id }}">{{ $data->judul }}</option>
                @endforeach
              </select>
              @error('buku') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
              <label>Member</label>
              <select wire:model="user" class="form-control">
                <option value="">--pilih--</option>
                @foreach($member as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              @error('user') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button wire:click="update" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete -->
  <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data</h5>
          <button class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus data ini?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button wire:click="destroy" class="btn btn-danger" data-dismiss="modal">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

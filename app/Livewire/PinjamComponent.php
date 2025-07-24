<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\User;
use App\Models\Pinjam;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class PinjamComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';

    public $pinjamId;
    public $user;
    public $buku;
    public $tgl_pinjam;
    public $tgl_kembali;
    public $id;

    public function render()
    {
        $data = [
            'member' => User::where('role', 'member')->get(),
            'book' => Buku::all(),
            'pinjam' => Pinjam::latest()->paginate(5),
        ];

        return view('livewire.pinjam-component', $data)
            ->layoutData(['title' => 'Pinjam Buku']);
    }

    public function store()
    {
        $this->validate([
            'buku' => 'required',
            'user' => 'required',
        ], [
            'buku.required' => 'Buku Harus Dipilih',
            'user.required' => 'User Harus Dipilih',
        ]);

        $this->tgl_pinjam = now()->format('Y-m-d');
        $this->tgl_kembali = now()->addDays(7)->format('Y-m-d');

        Pinjam::create([
            'user_id' => $this->user,
            'buku_id' => $this->buku,
            'tgl_pinjam' =>  $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => 'pinjam',
        ]);

        // Reset hanya properti terkait
        $this->reset(['buku', 'user']);

        session()->flash('success', 'Berhasil Diproses!');
        return redirect()->route('pinjam');
    }

    public function edit($id)
    {
        $pinjam = Pinjam::find($id);
        $this->id = $pinjam->id;
        $this->user = $pinjam->user_id;
        $this->buku = $pinjam->buku_id;
        $this->tgl_pinjam = $pinjam->tgl_pinjam;
        $this->tgl_kembali = $pinjam->tgl_kembali;
    }

    public function update()
    {
        $pinjam = Pinjam::find($this->id);
        $this->tgl_pinjam = now()->format('Y-m-d');
        $this->tgl_kembali = now()->addDays(7)->format('Y-m-d');
        $pinjam->update([
            'user_id' => $this->user,
            'buku_id' => $this->buku,
            'tgl_pinjam' =>  $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => 'pinjam',
        ]);
        $this->reset();

        session()->flash('success', 'Berhasil Ubah Data!');
        return redirect()->route('pinjam');  
    }

    public function confirm($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        $pinjam = Pinjam::find($this->id);
        $pinjam->delete();
        $this->reset();

        session()->flash('success', 'Berhasil Di Hapus!');
        return redirect()->route('pinjam');
    }
}

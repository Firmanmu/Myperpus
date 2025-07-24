<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MemberComponent extends Component
{   
    use WithPagination, WithoutUrlPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $nama, $telepon, $email, $alamat, $password, $cari, $member_id;

    public function render()
    {
        if ($this->cari != "") {
            $data['member'] = User::where('nama', 'like', '%' . $this->cari . '%')
                ->paginate(5);
        } else {
            $data['member'] = User::where('jenis', 'member')->paginate(5);
        }

        $layout['title'] = 'Kelola Member';
        return view('livewire.member-component', $data)->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'alamat' => 'required'
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'telepon.required' => 'Telepon Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'alamat.required' => 'Alamat Tidak Boleh Kosong'
        ]);

        User::create([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'jenis' => 'member'
        ]);

        session()->flash('success', 'Berhasil Disimpan!');
        return redirect()->route('member');
    }

    public function edit($id)
    {
        $member = User::find($id);

        if (!$member) {
            session()->flash('error', 'Data tidak ditemukan.');
            return;
        }

        $this->member_id = $member->id;
        $this->nama = $member->nama;
        $this->alamat = $member->alamat;
        $this->telepon = $member->telepon;
        $this->email = $member->email;
    }

    public function update()
    {
        $member = User::find($this->member_id);

        if (!$member) {
            session()->flash('error', 'Data tidak ditemukan.');
            return;
        }

        $member->update([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'jenis' => 'member'
        ]);

        session()->flash('success', 'Berhasil Diubah!');
        return redirect()->route('member');
    }

    public function confirm($id)
    {
        $this->member_id = $id;
    }

    public function destroy()
    {
        $member = User::find($this->member_id);

        if (!$member) {
            session()->flash('error', 'Data tidak ditemukan.');
            return;
        }

        $member->delete();
        session()->flash('success', 'Berhasil Dihapus!');
        return redirect()->route('member');
    }
}

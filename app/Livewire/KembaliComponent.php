<?php

namespace App\Livewire;

use DateTime;
use App\Models\Pinjam;
use Livewire\Component;
use App\Models\Pengembalian;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;


class KembaliComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $id;
    public $judul;
    public $member;
    public $tglkembali;
    public $lama;
    public $status;

    public function render()
    {
        $layout['title'] = 'Pengembalian Buku';
        $data['pinjam'] = Pinjam::where('status', 'pinjam')->paginate(5);
        $data['pengembalian'] = Pengembalian::paginate(5);
        return view('livewire.kembali-component', $data)->layoutData($layout);
    }

    public function pilih($id)
    {
        $pinjam = Pinjam::find($id);
        $this->judul = $pinjam->buku->judul;
        $this->member = $pinjam->user->nama;
        $this->tglkembali = $pinjam->tgl_kembali;
        $this->id = $pinjam->id;


        $kembali = new DateTime($this->tglkembali);
        $today = new DateTime();
        $selisih = $today->diff($kembali);
        // $this->status = $selisih->invert;
        if($selisih->invert == 1)
        {
            $this->status = true;
        } else {
            $this->status = false;
        }
        $this->lama = $selisih->d;
    }

    public function store()
    {
        if($this->status == true)
        {
            $denda = $this->lama * 1000;
        } else {
            $denda = 0;
        }
        $pinjam = Pinjam::find($this->id);

        Pengembalian::create([
            'pinjam_id' => $this->id,
            'tgl_kembali' => date('Y-m-d'),
            'denda' => $denda
        ]);
        $pinjam->update([
           'status' => 'kembali' 
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil di proses');
        return redirect()->route('kembali');
    }
}

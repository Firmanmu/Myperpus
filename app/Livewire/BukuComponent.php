<?php

namespace App\Livewire;

use App\Models\Buku;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class BukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $kategori, $judul, $penulis, $penerbit, $isbn, $tahun, $jumlah, $cari, $id;
    public function render()
    {
        if($this->cari!="")
        {
            $data['buku'] = Buku::where('judul', 'like', '%' . $this->cari . '%')->paginate(5);
        } else {
            $data['buku'] = Buku::paginate(5);
        }
        $data['category'] = Kategori::all();
        $layout['title'] = 'Kelola Buku';
        return view('livewire.buku-component', $data)->layoutData($layout);
    }
    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'isbn' => 'required',
            'jumlah' => 'required'
        ], [
            'judul.required' => 'Judul buku tidak boleh kosong!',
            'kategori.required' => 'Kategori buku tidak boleh kosong!',
            'penulis.required' => 'Penulis buku tidak boleh kosong!',
            'penerbit.required' => 'Penerbit buku tidak boleh kosong!',
            'Tahun.required' => 'Tahun tidak boleh kosong!',
            'isbn.required' => 'Isbn tidak boleh kosong!',
            'jumlah.required' => 'Jumlah buku tidak boleh kosong!'
        ]);

        Buku::create([
            'judul' => $this->judul,
            'kategori_id' => $this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil Ditambah!');
        return redirect()->route('buku');
    }
    public function edit($id)
    {
        $buku = Buku::find($id);
        $this->id = $buku->id;
        $this->judul = $buku->judul;
        $this->kategori = $buku->kategori->id;
        $this->penulis = $buku->penulis;
        $this->penerbit = $buku->penerbit;
        $this->tahun = $buku->tahun;
        $this->isbn = $buku->isbn;
        $this->jumlah = $buku->jumlah;
    }
    public function update()
    {
        $buku = Buku::find($this->id);
        $buku->update([
            'judul' => $this->judul,
            'kategori_id' => $this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil Di Ubah!');
        return redirect()->route('buku');
    }
    public function confirm($id)
    {
        $this->id = $id;
    }
    public function destroy()
    {
        $buku = Buku::find($this->id);
        $buku->delete();
        $this->reset();
        session()->flash('success', 'Berhasil Di Hapus!');
        return redirect()->route('buku');       
    }
}
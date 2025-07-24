<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\User;
use App\Models\Pinjam;
use Livewire\Component;
use App\Models\Pengembalian;

class HomeComponent extends Component
{
    public function render()
    {
        $x['title'] = "Home MyPerpus";
        $data['member'] = User::where('jenis', 'member')->count();
        $data['buku'] = Buku::count();
        $data['pinjam'] = Pinjam::where('status', 'pinjam')->count();
        $data['kembali'] = Pengembalian::count();
        return view('livewire.home-component', $data)->layoutData($x);
    }
}


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Numbertowords {

    protected $bilangan = array(
        "", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
    );

    public function __construct()
    {
        // kosongkan kalau tidak ada inisialisasi
    }

    public function convert_number($angka)
    {
        $angka = abs($angka);
        $hasil = " ";

        if ($angka < 12) {
            $hasil = " " . $this->bilangan[$angka];
        } else if ($angka < 20) {
            $hasil = $this->convert_number($angka - 10) . " belas";
        } else if ($angka < 100) {
            $hasil = $this->convert_number($angka / 10) . " puluh" . $this->convert_number($angka % 10);
        } else if ($angka < 200) {
            $hasil = " seratus" . $this->convert_number($angka - 100);
        } else if ($angka < 1000) {
            $hasil = $this->convert_number($angka / 100) . " ratus" . $this->convert_number($angka % 100);
        } else if ($angka < 2000) {
            $hasil = " seribu" . $this->convert_number($angka - 1000);
        } else if ($angka < 1000000) {
            $hasil = $this->convert_number($angka / 1000) . " ribu" . $this->convert_number($angka % 1000);
        } else if ($angka < 1000000000) {
            $hasil = $this->convert_number($angka / 1000000) . " juta" . $this->convert_number($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $hasil = $this->convert_number($angka / 1000000000) . " milyar" . $this->convert_number(fmod($angka,1000000000));
        } else if ($angka < 1000000000000000) {
            $hasil = $this->convert_number($angka / 1000000000000) . " trilyun" . $this->convert_number(fmod($angka,1000000000000));
        }

        return trim($hasil);
    }

}

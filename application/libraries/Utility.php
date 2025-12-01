<?php

/**
 * @author hendi
 * @copyright 2015
 */

class Utility {
    function __construct(){
        $this->ci =& get_instance();    
    }
   	
   	public function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
	}
    
    function tanggal_ind($tgl){
        $tanggal = explode('-',$tgl); 
        $bulan = $tanggal[1];
        $tahun = $tanggal[0];
        return $tanggal[2].'-'.$bulan.'-'.$tahun;
    }
    
    function tgl_format_id($tgl){
        $tanggal = explode('-',$tgl); 
        $bulan = $this-> getBulan($tanggal[1]);
        $tahun = $tanggal[0];
        return (int)substr($tanggal[2],0,2).' '.$bulan.' '.$tahun;
    }
    
    public function getBulan($bln){
		switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
    
    public function getBulan2($bln){
		switch ($bln){
			case 1: 
				return "Jan";
				break;
			case 2:
				return "Feb";
				break;
			case 3:
				return "Mar";
				break;
			case 4:
				return "Apr";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Jun";
				break;
			case 7:
				return "Jul";
				break;
			case 8:
				return "Ags";
				break;
			case 9:
				return "Sep";
				break;
			case 10:
				return "Okt";
				break;
			case 11:
				return "Nov";
				break;
			case 12:
				return "Des";
				break;
		}
	}
    
    public function autolink ($str){
        $str = eregi_replace("([[:space:]])((f|ht)tps?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str); //http
        $str = eregi_replace("([[:space:]])(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str); // www.
        $str = eregi_replace("([[:space:]])([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","\\1<a href=\"mailto:\\2\">\\2</a>", $str); // mail
        $str = eregi_replace("^((f|ht)tp:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $str); //http
        $str = eregi_replace("^(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $str); // www.
        $str = eregi_replace("^([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $str); // mail
        return $str;
    }
    
    public function format_rupiah($angka){
        $rupiah=number_format($angka,0,',','.');
        return $rupiah;
    } 
    
   	public function randomString($length) {
         $str = "";
         //$characters = array_merge(range('a','z'), range('A','Z'), range('0','9'));
         $characters = array_merge(range('a','z'), range('0','9'));
         $max = count($characters) - 1;
         for ($i = 0; $i < $length; $i++) {
              $rand = mt_rand(0, $max);
              $str .= $characters[$rand];
         }
         return $str;
    }
    
    public function createCaptcha($text) {
       $width = 75; //Ukuran lebar
       $height = 40; //Tinggi
       $im = imagecreate($width, $height);
       $bg = imagecolorallocate($im, 0, 0, 0);
       $len = 6; //Panjang karakter 
       $string = '';
       $string .= $text;
       
       //menambahkan titik2 gambar / noise
       $bgR = mt_rand(100, 200); $bgG = mt_rand(100, 200); $bgB = mt_rand(100, 200);
       $noise_color = imagecolorallocate($im, abs(255 - $bgR), abs(255 - $bgG), abs(255 - $bgB));
       
       for($i = 0; $i < ($width*$height) / 3; $i++) {
          imagefilledellipse($im, mt_rand(0,$width), mt_rand(0,$height), 3, rand(2,5), $noise_color);
       }
       
       // proses membuat tulisan
       $text_color = imagecolorallocate($im, 240, 240, 240);
       $rand_x = $width - 63; //rand(0, $width - 50);
       $rand_y = $height - 30; //rand(0, $height - 15);
       imagestring($im, 12, $rand_x, $rand_y, $string, $text_color);
       header ("Content-type: image/png"); //Output format gambar
       $img = imagepng($im);
       
       return $img;     
    }
    
    function right($value, $count){
        return substr($value, ($count*-1));
    }

    function left($string, $count){
        return substr($string, 0, $count);
    } 
    
    function dotrek($rek){
	   $nrek = strlen($rek);
	   switch ($nrek) {
            case 1:
			$rek = $this->left($rek,1);								
   			 break;
			case 2:
				$rek = $this->left($rek,1).'.'.substr($rek,1,1);								
   			 break;
			case 3:
				$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1);								
   			 break;
			case 5:
				$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);								
    		break;
			case 7:
				$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);								
    		break;
            case 29:
				$rek = $this->left($rek,21).'.'.substr($rek,23,1).'.'.substr($rek,24,1).'.'.substr($rek,25,1).'.'.substr($rek,26,2).'.'.substr($rek,28,2);								
    		break;
			default:
			$rek = "";	
	   }
	   return $rek;
    }

    function nol($value, $places){
        if(is_numeric($value)){
            $leading = "";
            for($x = 1; $x <= $places; $x++){
                $ceiling = pow(10, $x);
                if($value < $ceiling){
                    $zeros = $places - $x;
                    for($y = 1; $y <= $zeros; $y++){
                        $leading .= "0";
                    }
                    $x = $places + 1;
                }
            }
            $output = $leading . $value;
        } else{
            $output = $value;
        }
        
        return $output;
    }
    
    function angka($nilai){
        $number = floatval(str_replace(',', '.', str_replace('.', '', $nilai)));
        return $number;
    }
    
    function terbilang__($number) { #fungsi ini masih ada kesalahan. pd satu ratus, harusnya seratus, dst
        $hyphen = ' ';
        $conjunction = ' ';
        $separator = ' ';
        $negative = 'Minus ';
        $decimal = ' Koma ';
        $dictionary = array(0 => 'nol',1 => 'Satu',2 => 'Dua',3 => 'Tiga',4 => 'Empat',5 => 'Lima',6 => 'Enam',7 => 'Tujuh',
            8 => 'Delapan',9 => 'Sembilan',10 => 'Sepuluh',11  => 'Sebelas',12 => 'Dua Belas',13 => 'Tiga Belas',14 => 'Empat Belas',
            15 => 'Lima Belas',16 => 'Enam Belas',17 => 'Tujuh Belas',18 => 'Delapan Belas',19 => 'Sembilan Belas',20 => 'Dua Puluh',
            30 => 'Tiga Puluh',40 => 'Empat Puluh',50 => 'Lima Puluh',60 => 'Enam Puluh',70 => 'Tujuh Puluh',80 => 'Delapan Puluh',
            90 => 'Sembilan Puluh',100 => 'Ratus',1000 => 'Ribu',1000000 => 'Juta',1000000000 => 'Milyar',1000000000000 => 'Triliun',
        );
       
        if (!is_numeric($number)) {
            return false;
        }
       
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'terbilang only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
    
        if ($number < 0) {
            return $negative . $this->terbilang(abs($number));
        }
       
        $string = $fraction = null;
       
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
       
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->terbilang($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->terbilang($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->terbilang($remainder);
                }
                break;
        }
       
        //jika .00 tidak dicetak
        //if (null !== $fraction && is_numeric($fraction)) {
        if (null !== $fraction && is_numeric($fraction) && $fraction != 0) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
       
        return $string;
    }
    
    public function getNamaHari($tanggal) {
        //$tanggal = '2015-06-03';
        $day = date('D', strtotime($tanggal));
        $daylist = array(
        	'Sun' => 'Minggu',
        	'Mon' => 'Senin',
        	'Tue' => 'Selasa',
        	'Wed' => 'Rabu',
        	'Thu' => 'Kamis',
        	'Fri' => 'Jumat',
        	'Sat' => 'Sabtu'
        );
        
        return $daylist[$day];
    }

    function terbilang($number) {
	    $this->dasar = array(1 => 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
	    $this->angka = array(1000000000, 1000000, 1000, 100, 10, 1);
	    $this->satuan = array('milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
	 
	    $i = 0;
	    if ($number == 0) {
	    	$str = "nol";
	    } else {
			$str = "";
            
	       	while ($number != 0) {
	        	$count = (int)($number/$this->angka[$i]);
	      		
                if ($count >= 10) {
	          		$str .= $this->terbilang($count)." ".$this->satuan[$i]." ";
      		    } elseif ($count > 0 && $count < 10) {
	          		$str .= $this->dasar[$count]." ".$this->satuan[$i]." ";
	      		}
                
			  	$number -= $this->angka[$i] * $count;
			  	$i++;
		   }
           
		   $str = preg_replace("/satu puluh (\w+)/i", "\\1 Belas", $str);
		   $str = preg_replace("/satu (ribu|ratus|puluh|belas)/i", "Se\\1", $str);
		}
        
		$string = $str.'';
        #ucwords agar karakter awal huruf besar
    	return ucwords($string); 
    } 

    function cleanSPC($string) { //special character
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    //konversi untuk deviasi pada gauge chart di beranda
    function konversiOp ($op) {
        $cv = '';
        switch ($op) {
            case '<':
                $cv = '>';
                break;
            case '>':
                $cv = '<'; 
                break;  
            case '<=':
                $cv = '>='; 
                break;
            case '>=':
                $cv = '<='; 
                break;
            case '=':
                $cv = '!='; 
                break;
            case '!=':
                $cv = '='; 
                break;
        }
        return $cv;
    }
}


?>
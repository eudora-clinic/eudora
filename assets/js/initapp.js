//initapp.js
//Created By Hendi
//2022-03-31
//untuk initial aplikasi

var frmHeight = getClientHeight();
var frmWidth = getClientWidth();

function getClientHeight() {
	var theHeight;

	if (window.innerHeight) {
		theHeight=window.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
		theHeight=document.documentElement.clientHeight;
	} else if (document.body) {
		theHeight=document.body.clientHeight;
	}
	
	return theHeight;
}

function getClientWidth() {
    var theWidth;
    
	if (window.innerWidth) {
		theWidth=window.innerWidth;
    } else if (document.documentElement && document.documentElement.clientWidth) {
		theWidth=document.documentElement.clientWidth;
    } else if (document.body) {
		theWidth=document.body.clientWidth;
    }

	return theWidth;
}

var _mod;

$(function() {
    $('.ct-chart-donut').removeAttr('style');
    $('#indikator-warna svg').attr('height', '115px')
    //E: Beranda
    $('.bootstrap-select').css("width", "100%");
    $("#tgl-cetak.datepicker,#tgl-awal.datepicker,#tgl-akhir.datepicker").datetimepicker({
        format:"DD-MM-YYYY",
        date: new Date(),
        icons:{
            time:"fa fa-clock-o",
            date:"fa fa-calendar",
            up:"fa fa-chevron-up",
            down:"fa fa-chevron-down",
            previous:"fa fa-chevron-left",
            next:"fa fa-chevron-right",
            today:"fa fa-screenshot",
            clear:"fa fa-trash",
            close:"fa fa-remove"
        }
    }); 

    jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
        return this.each(function() {
            var select = this;
            var options = [];
            $(select).find('option').each(function() {
                options.push({value: $(this).val(), text: $(this).text()});
            });
            $(select).data('options', options);
            $(textbox).bind('change keyup', function() {
                var options = $(select).empty().data('options');
                var search = $(this).val().trim();
                var regex = new RegExp(search,"gi");
      
                $.each(options, function(i) {
                    var option = options[i];
                    if(option.text.match(regex) !== null) {
                        $(select).append(
                            $('<option>').text(option.text).val(option.value)
                        );
                    }
                });
                
                if (selectSingleMatch === true && $(select).children().length === 1) {
                    $(select).children().get(0).selected = true;
                }
            });            
        });
    };

    jQuery.ajaxSetup({
        //Setting async to false means that the statement you are calling has to complete before the next statement in your function can be called. If you set async: true then that statement will begin it's execution and the next statement will be called regardless of whether the async statement has completed yet.
        async : false,
        beforeSend: function() {
            $('#loading-status').show();
        },
        complete: function(){
            $('#loading-status').hide();
        },
        success: function() {}
    });
}); 

$("#ubah-password-form").submit(function (e) {
    e.preventDefault();
    var _formdata = new FormData(this);
    $.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data: _formdata, //$form.serialize(),  
        cache:false,
        contentType: false,
        processData: false,
        success: function(result) {
            if (result == 1) {
                swalMsg('Sukses', 'Ubah Password berhasil. Silahkan logout.', 'success');
            } else if (result == 0) {
                swalMsg('Gagal', 'Ubah Password gagal.', 'warning');
            } else {
                swalMsg('Gagal', result, 'warning');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swalMsg('Error!', 'status code: ' + jqXHR.status + ' errorThrown: ' + errorThrown + ' responseText: ' + jqXHR.responseText, 'danger');
        }
    });
});   

function loading(_sts) {
    if(_sts=='show') $('#loading-status').show();
    else $('#loading-status').hide();
}

var numberFormat = function (number, decimals, dec_point, thousands_sep) {
    //  discuss at: http://phpjs.org/functions/number_format/
    // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: davook
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Theriault
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Michael White (http://getsprink.com)
    // bugfixed by: Benjamin Lupton
    // bugfixed by: Allan Jensen (http://www.winternet.no)
    // bugfixed by: Howard Yeend
    // bugfixed by: Diogo Resende
    // bugfixed by: Rival
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    //  revised by: Luke Smith (http://lucassmith.name)
    //    input by: Kheang Hok Chin (http://www.distantia.ca/)
    //    input by: Jay Klehr
    //    input by: Amir Habibi (http://www.residence-mixte.com/)
    //    input by: Amirouche
    //   example 1: number_format(1234.56);
    //   returns 1: '1,235'
    //   example 2: number_format(1234.56, 2, ',', ' ');
    //   returns 2: '1 234,56'
    //   example 3: number_format(1234.5678, 2, '.', '');
    //   returns 3: '1234.57'
    //   example 4: number_format(67, 2, ',', '.');
    //   returns 4: '67,00'
    //   example 5: number_format(1000);
    //   returns 5: '1,000'
    //   example 6: number_format(67.311, 2);
    //   returns 6: '67.31'
    //   example 7: number_format(1000.55, 1);
    //   returns 7: '1,000.6'
    //   example 8: number_format(67000, 5, ',', '.');
    //   returns 8: '67.000,00000'
    //   example 9: number_format(0.9, 0);
    //   returns 9: '1'
    //  example 10: number_format('1.20', 2);
    //  returns 10: '1.20'
    //  example 11: number_format('1.20', 4);
    //  returns 11: '1.2000'
    //  example 12: number_format('1.2000', 3);
    //  returns 12: '1.200'
    //  example 13: number_format('1 000,50', 2, '.', ' ');
    //  returns 13: '100 050.00'
    //  example 14: number_format(1e-8, 8, '.', '');
    //  returns 14: '0.00000001'

    number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
    
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
    
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
        .join('0');
    }
    
    return s.join(dec);
}

//contoh 4500000 -> 4.500.000
function autoNumber(_obj,e) {
    //skip for arrow keys
    if  (e.which >= 37 && e.which <= 40) return;

    //format number
    $(_obj).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });        
} 

//===============base64 start===========================	 
var keyStr = "ABCDEFGHIJKLMNOP" +
             "QRSTUVWXYZabcdef" +
             "ghijklmnopqrstuv" +
             "wxyz0123456789+/" +
             "=";
             
function base64encode(input){
    input = escape(input);
    var output = "";
    var chr1, chr2, chr3 = "";
    var enc1, enc2, enc3, enc4 = "";
    var i = 0;

    do{
        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if(isNaN(chr2)){
            enc3 = enc4 = 64;
        }else if (isNaN(chr3)) {
            enc4 = 64;
        }

        output = output +
                keyStr.charAt(enc1) +
                keyStr.charAt(enc2) +
                keyStr.charAt(enc3) +
                keyStr.charAt(enc4);
        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";
    }while(i < input.length);

    return output;
}

function base64decode(input) {
    var output = "";
    var chr1, chr2, chr3 = "";
    var enc1, enc2, enc3, enc4 = "";
    var i = 0;

    //remove all characters that are not A-Z, a-z, 0-9, +, /, or =
    var base64test = /[^A-Za-z0-9\+\/\=]/g;
 
    if(base64test.exec(input)){
        alert("There were invalid base64 characters in the input text.\n" +
              "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
              "Expect errors in decoding.");
    }
 
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    do{
        enc1 = keyStr.indexOf(input.charAt(i++));
        enc2 = keyStr.indexOf(input.charAt(i++));
        enc3 = keyStr.indexOf(input.charAt(i++));
        enc4 = keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if(enc3 != 64){
            output = output + String.fromCharCode(chr2);
        }

        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }

        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";

    }while(i < input.length);

    return unescape(output);
}

//===============base64 end===========================

function nol(angka, digit){
    digit -= angka.toString().length;
    
    if (digit > 0){
        return new Array( digit + (/\./.test( angka ) ? 2 : 1) ).join('0') + angka;
    }
    
    return angka + ""; // always return a string
}

function angka(nilai,dec){
    if (nilai== null){
        nilai = '0';    
    }
    
    var numberString = nilai;
    numberString = numberString
        .replace(/\./g, '')  // replace all separators
        .replace(/,/, '.');  // replace comma with dot 
    
    var parsed = parseFloat(numberString).toFixed(dec);
    
    return parsed;
}

function swalMsg(_title, _text, _type) {
    swal({
        title: _title,
        text: _text,
        type: _type,
        confirmButtonClass: "btn btn-success",
        buttonsStyling: false
    }).catch(swal.noop);
}

$(document).ready(function () {
    console.log("Script utama di index selesai dijalankan.");

    // Jalankan script dalam content setelah index siap
    $(".content").trigger("scriptReady");
});


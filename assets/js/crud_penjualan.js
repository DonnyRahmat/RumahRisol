$(document).ready(function(){

  $(document).on('keydown', '.nmproduk', function() {

   var id = this.id;
   var splitid = id.split('_');
   var index = splitid[1];

 // Initialize jQuery UI autocomplete
   $( '#'+id ).autocomplete({
    source: function( request, response ) {
     $.ajax({
      url: "../../admin/penjualan/l_data.php",
      type: 'post',
      dataType: "json",
      data: {
       search: request.term,
       request:1
      },
      success: function( data ) {
       response( data );
      }
     });
    },
    select: function (event, ui) {
     $(this).val(ui.item.label); // display the selected text
     var id_produk = ui.item.value; // selected value

     // AJAX
     $.ajax({
      url: '../../admin/penjualan/l_data.php',
      type: 'post',
      data: {
        id_produk:id_produk,
        request:2
      },
      dataType: 'json',
      success:function(response){

       var len = response.length;

       if(len > 0){
        var idp  = response[0]['idp'];
        var nb   = response[0]['nb'];
        var hj   = response[0]['hj'];
        var s   = response[0]['s'];

        document.getElementById('idproduk_'+index).value = idp;
        document.getElementById('harga_'+index).value = hj;
        document.getElementById('qty_'+index).value = 1;
        document.getElementById('st_'+index).value = document.getElementById('qty_'+index).value * document.getElementById('harga_'+index).value;
        var numb = parseInt(s);
        var min = 1;

        // fungsi max stok dan min stok
        $('#qty_'+index).attr("min", min);
        $('#qty_'+index).attr("max", numb);
        $('#qty_'+index).on('keydown keyup', function(e){

            if ($(this).val() > numb && e.keyCode !== 46 && e.keyCode !== 8) {
               e.preventDefault();
               $(this).val(numb);
            }else if ($(this).val() == "0" || e.keyCode == 189) {
               $(this).val(1);
            }

            var h = $('#qty_'+index).val() * $('#harga_'+index).val() - $('#diskon_'+index).val();
            var h2 = $('#st_'+index).val(h);

            var sum = 0;
            $('.st').each(function(){
              if(!isNaN(this.value) && this.value.length!=0)
              {
                sum += parseFloat(this.value);
              }
            });
            $('#hasil').css({"font-weight": "bold","text-decoration": "none", "font-size": "1em"});
            $('#totalan').val(sum);

            // $('#hasil').text(h2);
        });//akhir fungsi max min stok
       }
      }
     });
     return false;
    }
   });
  });


// Add more
  $('#addmore').click(function(){

   // Get last id
   var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');
   // console.log(lastname_id);
   if (lastname_id == undefined) {
      var index = 1;
   }else{
      var split_id = lastname_id.split('_');
      var index = Number(split_id[1]) + 1;
   }


   // New index
   var html = "<tr class='tr_input'><td><input type='text' class='nmproduk' id='nmproduk_"+index+"' placeholder='Masukkan Nama produk' name='nmproduk[]' required><input type='number' class='idproduk' id='idproduk_"+index+"' name='idproduk[]' hidden><input type='text' class='id_prdmsk' id='id_prdmsk_"+index+"' hidden></td><td><input type='number' class='harga' id='harga_"+index+"' name='harga[]' readonly required></td><td><input type='number' class='diskon' id='diskon_"+index+"' required></td><td><input type='number' class='qty' id='qty_"+index+"' name='qty[]' required></td><td><input type='number' class='st' id='st_"+index+"' name='st[]' value='' readonly> </td><td><input type='button' value='Delete' class='delete'></td></tr>";

   // Append data
   $('.aut').append(html);
  });//end add more

  //delete data
  $('table').on('click','.delete',function(){
      $(this).closest('tr').remove();
  });


  //save data
  $('#save').click(function(){
      var idproduk = [];
      var harga = [];
      var qty = [];
      var diskon = [];


      $('.idproduk').each(function(){
          idproduk.push($(this).val());
      });

      $('.harga').each(function(){
          harga.push($(this).val());
      });

      $('.qty').each(function(){
          qty.push($(this).val());
      });

      $('.diskon').each(function(){
          diskon.push($(this).val());
      });

      var cash = parseFloat($('#bayar').val());
      var kembalian = parseFloat($('#kembalian').val());
      var idj = $('#idj').val();
      var c = parseFloat($('#totalan').val());
      if (cash < c) {
        // console.log("kurang");
        Metro.notify.create("Pembayaran Kurang", "Informasi", {cls: "info"});
      }else{
        // console.log("okeh");
        $.ajax({
         url:"crud_penjualan.php",
         method:"POST",
         data:{
           idproduk:idproduk,
           harga:harga,
           qty:qty,
           diskon:diskon,
           cash:cash,
           kembalian:kembalian,
           idj:idj
         },
         success:function(data){
          console.log(data);
          Metro.notify.create(data, "Informasi", {cls: "info"});
          if (data=="Transaksi Sukses") {
            $(".aut").empty();
            var res = "<tr class='tr_input'><td><input type='text' class='nmproduk' id='nmproduk_1' placeholder='Masukkan Nama produk' name='nmproduk[]' required><input type='number' class='idproduk' id='idproduk_1' name='idproduk[]' hidden></td><td><input type='number' class='harga' name='harga[]' id='harga_1' readonly required></td><td><input type='number' class='diskon' id='diskon_1' required></td><td><input type='number' class='qty' name='qty[]' id='qty_1' required></td><td><input type='number' class='st' id='st_1' name='st[]' value='' readonly> </td></tr>";
            $(".aut").append(res);
            $('#bayar').val('');
            $('#kembalian').val('');
            $('#totalan').val('');
            var add = Number($("#idj").val()) + Number(1)
            $('#idj').val(add);
          }
         }
       }); //end ajax
     } //end if bayar < total


  });//end func save

  $('#reset').click(function(){
    $('#nmproduk_1').val('');
    $('#id_produk_1').val('');
    $('#id_detil_prdmsk_1').val('');
    $('#id_prdmsk_1').val('');
    $('#stok_1').val('');
    $('#ukuran_1').val('');
    $('#harga_beli_1').val('');
    $('.jml_prdmsk').val('');
  });

  $('#batal').click(function(){
    $('.delete').show();
    $('#nmproduk_1').val('');
    $('#stok_1').val('');
    $('#ukuran_1').val('');
    $('#harga_beli_1').val('');
    $('.jml_prdmsk').val('');
    $('#id_detil_prdmsk').val('');
    $('#addmore').show();
    $('#save').show();
    $('#update').hide();
    $(this).hide();
  });


}); //akhir doc ready

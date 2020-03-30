$(document).ready(function() {
    $('#simpanDataUser').click(function(){
      var fd = new FormData();
      fd.append('saveDat', '1');
      fd.append('ktp', $('#file')[0].files[0]);
      fd.append('np', $('#nama_pegawai').val());
      fd.append('u', $('#username').val());
      fd.append('pass', $('#password').val());
      fd.append('alamat', $('#alamat').val());
      fd.append('telp', $('#no_telp').val());
      fd.append('tl', $('#tgl_lahir').val());
      fd.append('tm', $('#tgl_masuk').val());
      fd.append('akses', $('#akses').val());

      $.ajax({
        url: 'operate.php',
        type:'post',
        data:fd,
        contentType: false,
        processData: false,
        cache: false,
        dataType:'json',
        success: function(json){
             if (json['error']) {
                 for (i in json['error']) {
                    Metro.notify.create(json['error'][i], "Informasi", {cls: "alert"});
                 }
             } else {
                    Metro.notify.create(json['msg'], "Informasi", {cls: "success"});
             }
             var table = $('#example').DataTable();
             table.draw('page');
        },
      }) //end ajax function
    }) //end proses function

    var dataTable=$('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"fetch.php",
            type:"post"
        }
    });

    $('#example tbody').on('click', '#editU', function(){
     var data = dataTable.row( $(this).parents('tr') ).data();
     var updId = data[0];
     $('#simpanDataUser').hide();
     $('#updateDataUser').show();
     $('#batalDataUser').show();
     $.ajax({
          url:'operate.php',
          method:'post',
          data:{
            'getUpd':1,
            'updId':updId
          },
          dataType:'json',
          success:function(json){
               $('#iduser').val(updId);
               $('#nama_pegawai').val(json[0].fullname);
               $('#username').val(json[0].user);
               $('#password').val(json[0].pass);
               $('#password').attr('readonly', true);
               $('#alamat').val(json[0].alamat);
               $('#no_telp').val(json[0].telp);
               $('#tgl_lahir').attr('data-value', json[0].tl);
               $('#tgl_masuk').attr('data-value', json[0].tm);
               $('#akses').val(json[0].role);
          } //end success
     }); //end ajax edit
   }); //end edit func

   $('#resetDataUser').click(function() {
     reset();
   })

   $('#updateDataUser').click(function(){
     var ud = new FormData();
     ud.append('updateDat', '1');
     ud.append('iduser', $('#iduser').val());
     ud.append('ktp', $('#file')[0].files[0]);
     ud.append('np', $('#nama_pegawai').val());
     ud.append('u', $('#username').val());
     ud.append('pass', $('#password').val());
     ud.append('alamat', $('#alamat').val());
     ud.append('telp', $('#no_telp').val());
     ud.append('tl', $('#tgl_lahir').val());
     ud.append('tm', $('#tgl_masuk').val());
     ud.append('akses', $('#akses').val());
     $.ajax({
       url:'operate.php',
       method:'post',
       data:ud,
       contentType: false,
       processData: false,
       cache: false,
       dataType:'json',
       success:function(json){
         console.log(json);
         if (json['error']) {
             for (i in json['error']) {
                Metro.notify.create(json['error'][i], "Informasi", {cls: "alert"});
             }
         } else {
                Metro.notify.create(json['msg'], "Informasi", {cls: "success"});
         }
         reset();
         var table = $('#example').DataTable();
         table.draw('page');
       } //end success
     }); //end ajax
   }); //end update func

   $('#batalDataUser').click(function(){
     $('#simpanDataUser').show();
     $('#updateDataUser').hide();
     $('#updateDataUser').hide();
     $('.deleteU').show();
     $('#password').attr('readonly', false);
     $(this).hide();
     reset();
   })

   function reset() {
       $('#nama_pegawai').val('');
       $('#username').val('');
       $('#password').val('');
       $('#password').attr('placeholder', '');
       $('#alamat').val('');
       $('#no_telp').val('');
       $('#no_telp').val('');
       $('#ktp').val('');
   };

   var dtModul=$('#tabelModul').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           url:"fetch_modul.php",
           type:"post"
       }
   });

   $('#simpanDataModul').click(function(){
     // alert('okeh');
     var nm = $('#nama_modul').val();
     var link = $('#link_modul').val();
     var akses = $('#akses_modul').val();
     var icon = $('#icon_modul').val();
     $.ajax({
       url:'operate.php',
       method:'post',
       dataType:'json',
       data:{
         'saveMod':1,
         'nm':nm,
         'link':link,
         'akses':akses,
         'icon':icon
       },
       success:function(json){
         // console.log(json['msg']);
         if (json['error']) {
           for (i in json['error']) {
             Metro.notify.create(json['error'][i], "Informasi", {cls: "alert"});
           }
         } else {
           Metro.notify.create(json['msg'], "Informasi", {cls: "success"});
           var table = $('#tabelModul').DataTable();
           table.draw('page');
         }
       }
     });
   })

   $('#tabelModul tbody').on('click', '#editModul', function(){
    var data = dtModul.row( $(this).parents('tr') ).data();
    var updModul = data[0];
    // console.log(updModul);
    $('#simpanDataModul').hide();
    $('#updateDataModul').show();
    $('#batalDataModul').show();
    $.ajax({
         url:'operate.php',
         method:'post',
         data:{
           'getUpdModul':1,
           'updMod':updModul
         },
         dataType:'json',
         success:function(json){
              $('#idmod').val(updModul);
              $('#nama_modul').val(json[0].nm);
              $('#link_modul').val(json[0].lm);
              $('#akses_modul').val(json[0].a);
              $('#icon_modul').val(json[0].i);
         } //end success
    }); //end ajax edit
  }); //end edit func

  $('#updateDataModul').click(function(){
    var idUpdMod = $('#idmod').val();
    var nama_modul = $('#nama_modul').val();
    var link_modul = $('#link_modul').val();
    var access = $('#akses_modul').val();
    var icon = $('#icon_modul').val();
    $.ajax({
      url:'operate.php',
      method:'post',
      data:{
        'saveUpdModul':1,
        'idUpdMod':idUpdMod,
        'nama_modul':nama_modul,
        'link_modul':link_modul,
        'access':access,
        'icon':icon,
      },
      dataType:'json',
      success:function(json){
        console.log(json);
        if (json['error']) {
            for (i in json['error']) {
               Metro.notify.create(json['error'][i], "Informasi", {cls: "alert"});
            }
        } else {
               Metro.notify.create(json['msg'], "Informasi", {cls: "success"});
        }
        reset_modul();
        var tabelModul = $('#tabelModul').DataTable();
        tabelModul.draw('page');
        reset_modul();
        $('#batalDataModul').hide();
        $('#updateDataModul').hide();
        $('#simpanDataModul').show();
      } //end success
    }); //end ajax
  }); //end update func

  $('#tabelModul tbody').on('click', '#deleteModul', function(){
      var data = dtModul.row( $(this).parents('tr') ).data();
      var delIdModul = data[0];
      // console.log(delId);
      Metro.dialog.create({
          title: "Warning",
          content: "<div>Apakah anda yakin akan menghapus data ini?</div>",
          actions: [
              {
                  caption: "Ya",
                  cls: "js-dialog-close alert",
                  onclick: function(){
                      $.ajax({
                        url:'operate.php',
                        method:'post',
                        data:{
                          'delModul':1,
                          'delIdModul':delIdModul,
                        },
                        dataType:'json',
                        success:function(json){
                          var tabelModul = $('#tabelModul').DataTable();
                          tabelModul.draw('page');
                          Metro.notify.create(json['msg'], "Informasi", {cls: "success"});
                        }
                      })
                  }
              },
              {
                  caption: "Tidak",
                  cls: "js-dialog-close",
                  onclick: function(){
                  }
              }
          ]
      });
  }); //end delete mod func


  $('a.user').click(function(e) {
    var umod = this.id;
    // console.log(umod);
       $.ajax({
         url:"umod.php",
         type:"post",
         dataType: 'JSON',
         data:{
           umod:umod
         },
         success: function(json){
           $('table#hasil tbody').empty();
            // console.log(json);
            $('table#hasil').append(json);
             // var len = response.length;
             // for(var i=0; i<len-1; i++){
             //   var nm = response[i].nm_bar;
             //   var msk = response[i].brg_msk;
             //   var hbm = response[i].hbm;
             //   var klr = response[i].brg_klr;
             //   var hbk = response[i].hbk;
             //   var stok = response[i].stok;
             //   var ns = response[i].ns;
             //   var tambah = "<tr class='data_lap'>" +
             //                 "<td align='center'>" + nm + "</td>" +
             //                 "<td align='center'>" + msk + "</td>" +
             //                 "<td align='center' bgcolor='#8FBC8F'>" + hbm + "</td>" +
             //                 "<td align='center'>" + klr + "</td>" +
             //                 "<td align='center' bgcolor='#8FBC8F'>" + hbk + "</td>" +
             //                 "<td align='center'>" + stok + "</td>" +
             //                 "<td align='center' bgcolor='#E6E6FA'>" + ns + "</td>" +
             //               "</tr>";
             //     $("#getLap tbody").append(tambah);
             // }
         } //end success
       }); //end ajax
  });

  $('#batalDataModul').click(function(){
    $('#simpanDataModul').show();
    $('#updateDataModul').hide();
    $('.deleteModul').show();
    $(this).hide();
    reset_modul();
  });

  $('#resetDataModul').click(function(){
    reset_modul();
  })

  function reset_modul() {
      $('#idmod').val('');
      $('#nama_modul').val('');
      $('#link_modul').val('');
      $('#access').val('');
      $('#icon_modul').val('');
  };


}); // end document


$(function(){ 

  // SWEETALERT
  const flashMsg = $('#flash-alert').data('flash');

  var titleModalUser = $('#modalUserLabel').data('title');
  var titleModalInvoice = $('#modalInvoiceLabel').data('title');
  var titleModalActee = $('#modalActeeLabel').data('title');

  var baseUrl = $('#base-url').data('url');

  var userid = $('#thisactive').data('userid');
  var useracc = $('#thisactive').data('useracc');

  if (flashMsg){
    var is_confirm = true;
    var getTimer = null;
    var getStr = flashMsg.split('-');

    // title = [0], text = [1], type = [2]
    var titleMsg = getStr[0];
    var textMsg = getStr[1];
    var typeMsg = getStr[2];

    if (titleMsg.includes("Masuk") || titleMsg.includes("Keluar")){
      is_confirm = false;
      getTimer = 2000;
    }

    Swal.fire({
      title: titleMsg,
      text: textMsg,
      showConfirmButton: is_confirm,
      icon: typeMsg,
      timer: getTimer
    });
  }


  $('.logoutBtn').on('click', function(e){
    e.preventDefault();
    var target = $(this).attr('href');

    Swal.fire({
      title: 'Konfirmasi Keluar!',
      text: 'Yakin ingin keluar dari aplikasi?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batalkan',
      confirmButtonText: 'Keluar!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.location.href = target;
      }
    })
  });


  $(document).on('click', '.dropBtn', function(e){
    e.preventDefault();
    var target = $(this).attr('href');

    Swal.fire({
      title: 'Konfirmasi Hapus!',
      text: 'Yakin ingin menghapus data? data akan dihapus secara permanen!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Batalkan',
      confirmButtonText: 'Hapus Data!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.location.href = target;
      }
    })
  });
  // END OF SWEETALERT


  // DATATABLES
  if ($('#dataTables').length > 0){
    $.fn.DataTable.ext.pager.numbers_length = 5;

    var tabLee = $('#dataTables').DataTable({
      responsive: true,
      pageLength: 10,
      pagingType: 'simple_numbers',
      ordering: false,
      fixedColumns: {
        leftColumns: 1
      },
      language: {
        search: 'Cari:',
        emptyTable: 'Tidak ada data yang tersedia pada tabel ini',
        info: 'Baris _START_ - _END_ dari total _TOTAL_ baris',
        infoEmpty: 'Menampilkan 0 dari total 0 hasil',
        infoFiltered: '(disaring dari total _MAX_ baris)',
        lengthMenu: 'Lihat per _MENU_ baris',
        loadingRecords: 'Sedang memuat...',
        zeroRecords: 'Tidak ditemukan data yang sesuai',
        infoThousands: ",",
        searchPlaceholder: 'Kata kunci...',
        paginate: {
          previous: '&laquo;',
          next: '&raquo;'
        }
      }
    });
    new $.fn.DataTable.FixedHeader(tabLee);
  }
  // END OF DATATABLES


  // CUSTOM FUNCTION
  // DATA MEMBER
  $('#addUserBtn').on('click', function(){
    $('#modalUserLabel').html('Tambah '+titleModalUser);
    $('#resetPass').addClass('d-none');
    $('#modalAlert1').addClass('d-none');
    $('#modalAlert2').addClass('d-none');
    $('#userForm').attr('action', baseUrl+'adm/storeUser');

    $('#name').val('');
    $('#bank').val('');
    $('#account').val('');
  });


  $(document).on('click', '.editUser', function(){
    var dataId = $(this).data('id');

    $('#reset').prop('checked', false);
    $('#modalAlert2').addClass('d-none');
    $('#modalUserLabel').html('Ubah '+titleModalUser);
    $('#resetPass').removeClass('d-none');
    $('#userForm').attr('action', baseUrl+'adm/editUser');
    $('#modalAlert1').removeClass('d-none');

    $('#reset').click(function(){
      if ($(this).is(':checked')){
        $('#modalAlert2').removeClass('d-none');
      }else{
        $('#modalAlert2').addClass('d-none');
      }
    });

    $.ajax({
      url: baseUrl+'adm/getUserEdit/',
      data: { id: dataId },
      method: 'post',
      dataType: 'json',
      success: function(data){
        $('#name').val(data.name);
        $('#bank').val(data.bank);
        $('#bef-acc').val(data.account);
        $('#user-id').val(data.id);
        $('#account').val(data.account);
      }
    });
  })


  // UNSET DISABLED 'sender' OPTION
  $('#saveInvoice').on('click', function(){
    $('#sender').removeAttr('disabled');
  });


  // DATA INVOICE
  $('#addInvoiceBtn').on('click', function(){
    var imgPathOff = baseUrl+'upload/invoice/invoice.png';

    $('#modalInvoiceLabel').html('Tambah '+titleModalInvoice);
    $('#invoiceForm').attr('action', baseUrl+'mod/storeInvoice');
    $('#senderLabel').html('Rekening Pengirim (Anda)');

    $('#reciever').prop('selectedIndex', 0);
    $('#act').prop('selectedIndex', 0);
    $('#sender option:contains('+useracc+')').prop('selected', true);
    $('#date').val('');
    $('.custom-file-label').html('Pilih Gambar (.jpg/.png)');
    $('#preview').attr('src',imgPathOff);
  });


  $(document).on('click', '.editInvoice', function(){
    var imgFile = $(this).data('imgpath');
    var imgPathOn = baseUrl+'upload/invoice/'+imgFile;
    var dataId = $(this).data('id');

    $('#modalInvoiceLabel').html('Ubah '+titleModalInvoice);
    $('#invoiceForm').attr('action', baseUrl+'mod/editInvoice');
    $('#senderLabel').html('Rekening Pengirim');
    $('.img').html(imgFile);
    $('#preview').attr('src',imgPathOn);

    $.ajax({
      url: baseUrl+'mod/getInvoiceEdit/',
      data: { id: dataId },
      method: 'post',
      dataType: 'json',
      success: function(data){
        $('#invoice-id').val(data.id);
        $('#def-img').val(data.image);
        $('#reciever option[value='+data.reciever_id+']').attr('selected', true);
        $('#sender option[value='+data.sender_id+']').attr('selected', true);
        $('#act option[value='+data.activity_id+']').attr('selected', true);
        $('#date').val(data.date);
      }
    });
  });


  $('#addActBtn').on('click', function(){
    $('#modalActeeLabel').html('Tambah '+titleModalActee);
    $('#acteeForm').attr('action', baseUrl+'adm/storeAct');

    $('#title').val('');
    $('#alias').val('');
    $('#s-date').val('');
    $('#e-date').val('');
  });


  $(document).on('click', '.editAct', function(){
    $('#modalActeeLabel').html('Ubah '+titleModalActee);
    $('#acteeForm').attr('action', baseUrl+'adm/editAct');

    var dataId = $(this).data('id');

    $.ajax({
      url: baseUrl+'adm/getActEdit/',
      data: { id: dataId },
      method: 'post',
      dataType: 'json',
      success: function(data){
        $('#def-als').val(data.alias);
        $('#act-id').val(data.id);
        $('#title').val(data.title);
        $('#alias').val(data.alias);
        $('#s-date').val(data.start_date);
        $('#e-date').val(data.end_date);
      }
    });
  });


  $(document).on('click', '.userModf', function(){
    var imgFile = $(this).data('imgpath');
    var imgPathOn = baseUrl+'upload/profile/'+imgFile;
    var dataId = $(this).data('id');

    $('.optAlert').addClass('d-none');
    $('#modalModfLabel').html('Ubah Profil');
    $('#moduserForm').attr('action', baseUrl+'usr/editUser');
    $('#uaccount').val('');
    $('.user-reset').addClass('d-none');
    $('.user-edit').removeClass('d-none');
    $('.ava').html(imgFile);
    $('#avaPreview').attr('src',imgPathOn);

    $('#uaccount').keyup(function(){
      $('.optAlert').removeClass('d-none');
    });
    
    $.ajax({
      url: baseUrl+'usr/getUserEdit/',
      data: { id: dataId },
      method: 'post',
      dataType: 'json',
      success: function(data){
        $('#uname').val(data.name);
        $('#ubank').val(data.bank);
        $('#uaccount').val(data.account);
      }
    });
  });


  $(document).on('click', '.userReset', function(){
    $('#modalModfLabel').html('Ganti Password');
    $('#moduserForm').attr('action', baseUrl+'usr/resetPass');
    $('.user-edit').addClass('d-none');
    $('.user-reset').removeClass('d-none');

    $('#oldpass').val('');
    $('#newpass').val('');
    $('#repass').val('');
    $('#change-pass').prop('checked', false);
    $('.userPass').attr('type', 'password');
  });


  $('.show-tabs').on('click', function(){
    if ($('.u-tabs').hasClass('d-none')){
      $(this).html('Sembunyikan Riwayat &laquo;');
      $(this).removeClass('btn-primary');
      $(this).addClass('btn-danger');
      $('.u-tabs').removeClass('d-none');
    }else{
      $(this).html('Riwayat Bukti Transfer &raquo;');
      $(this).removeClass('btn-danger');
      $(this).addClass('btn-primary');
      $('.u-tabs').addClass('d-none');
    }
  });


  $('#show-pass').hover(function(){
    $('#show-pass li').removeClass('fa-eye');
    $('#show-pass li').addClass('fa-eye-slash');
    $('#show-pass').addClass('btn-danger');
    $('#pass').attr('type', 'text');
  }, function(){
    $('#show-pass li').removeClass('fa-eye-slash');
    $('#show-pass li').addClass('fa-eye');
    $('#show-pass').removeClass('btn-danger');
    $('#pass').attr('type', 'password');
  });


  $('#change-pass').click(function(){
    if ($(this).is(':checked')){
      $('#change-pass').removeClass('btn-secondary');
      $('#change-pass').addClass('btn-danger');
      $('.show-icon').removeClass('fa-eye');
      $('.show-icon').addClass('fa-eye-slash');
      $('.userPass').attr('type', 'text');
    }else{
      $('#change-pass').removeClass('btn-danger');
      $('#change-pass').addClass('btn-secondary');
      $('.show-icon').removeClass('fa-eye-slash');
      $('.show-icon').addClass('fa-eye');
      $('.userPass').attr('type', 'password');
    }
  });


  $('#image').on('change', function(){
    const img = document.querySelector('#image');
    const imgLabel = document.querySelector('.img');
    const imgPreview = document.querySelector('#preview');

    imgLabel.textContent = img.files[0].name;

    const getFile = new FileReader();
    getFile.readAsDataURL(img.files[0]);

    getFile.onload = function(e){
      imgPreview.src = e.target.result;
    }
  });


  $('#avatar').on('change', function(){
    const img = document.querySelector('#avatar');
    const imgLabel = document.querySelector('.ava');
    const imgPreview = document.querySelector('#avaPreview');

    imgLabel.textContent = img.files[0].name;

    const getFile = new FileReader();
    getFile.readAsDataURL(img.files[0]);

    getFile.onload = function(e){
      imgPreview.src = e.target.result;
    }
  });
  // END OF CUSTOM FUNCTION

});
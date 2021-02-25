<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  function fetch_data(){
    $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.fetch_data') }}",
        columns: [
          { data: 'id', name: 'id',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).addClass('text-center');
             }
          },
          { data: 'name', name: 'name'},
          { data: 'email', name: 'username'},
          { data: 'status', name: 'status',
           "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.status == "Active"){
                  $(nTd).html(`<span class="badge bg-success text-white">${oData.status}</span>`);
                } else {
                  $(nTd).html(`<span class="badge bg-danger text-white">${oData.status}</span>`);
                }
             }
          },
          { data: 'is_admin', name: 'role',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.is_admin == 0){
                  $(nTd).html('<span class="badge bg-success text-white">User</span>');
                } else {
                  $(nTd).html('<span class="badge bg-primary text-white">Admin</span>');
                }
             }
          },
          {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
          },
        ],
        createdRow: function(row, data, dataIndex){
          if(data['status'] == "Deactivated"){
            $(row).css('backgroundColor', '#ffc8d3');
          }
         }
      });
  }

  $(document).ready(function(){
    fetch_data();
  });

  var token = $('input[name="_token"]').val();

  $(document).on('change', '#is_admin', function(e){
    var checked = (e.target.checked) ?  $('#is_admin').val(1) :  $('#is_admin').val(0); $('#edit_is_admin').removeAttr('checked');
  });

  $(document).on('change', '#edit_is_admin', function(e){
    (e.target.checked) ?  $('#edit_is_admin').val(1) :  $('#edit_is_admin').val(0); $('#edit_is_admin').removeAttr('checked');
  });

  $(document).on('click', '#new-user', function(){
    var name = $('#name').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var is_admin = $('#is_admin').val();

    if(name != '' && email != '' && password != ''){
      $.ajax({
        url: "{{ route('user.new_user') }}",
        method: "POST",
        data: {
          name: name,
          email: email,
          password: password,
          is_admin: is_admin,
          _token: token,
        },
        success: function(data){
          $('#name').val('');
          $('#email').val('');
          $('#password').val('');
          $('#add-user').modal('hide');
          $('#success').removeClass('d-none');
          $('#success').addClass('d-block');
          $('#success-text').text(data);
          $('#user-table').DataTable().ajax.reload();
        }
      })
    } else {
      $('#name').val('');
      $('#email').val('');
      $('#password').val('');
      $('#add-user').modal('hide');
      $('#error').removeClass('d-none');
      $('#error').addClass('d-block');
      $('#danger-text').text('Both fields are required to have a value.');
    }
  });

  $(document).on('click', '#edit-user', function(){
    $.ajax({
      url: "{{ route('user.edit_user') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr("data-id"),
        _token: token
      },
      success: function(data){
        $('#edit_name').val(data.name);
        $('#edit_email').val(data.email);
        $('#edit_is_admin').val(data.is_admin);
        $('#update_user').attr('data-id', data.id);
        (data.is_admin == 0) ? $('#edit_is_admin').removeAttr('checked') : "";
      }
    })
  });

  $(document).on('click', '#update_user', function(){
    var updated_name = $('#edit_name').val();
    var updated_email = $('#edit_email').val();
    var updated_privilege = $('#edit_is_admin').val();

    if(updated_name != '' && updated_email != '' && updated_privilege != ''){
      $.ajax({
        url: "{{ route('user.update_user') }}",
        method: "POST",
        data: {
          id: $(this).attr('data-id'),
          name: updated_name,
          email: updated_email,
          is_admin: updated_privilege,
          _token: token
        },
        success: function(data){
          $('#modal-edit-user').modal('hide');
          $('#success').removeClass('d-none');
          $('#success').addClass('d-block');
          $('#success-text').text(data);
          $('#user-table').DataTable().ajax.reload();
        }
      })
    } else {
      $('#edit_name').val('');
      $('#edit_email').val('');
      $('#modal-edit-user').modal('hide');
      $('#error').removeClass('d-none');
      $('#error').addClass('d-block');
      $('#danger-text').text('Both fields are required to have a value.');
    }
  });

  $(document).on('click', '#user-deactivate-confirmation', function(){
    $.ajax({
      url: "{{ route('user.confirm_user_deactivate') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $("#deactivate-user-name").text(data.name);
        $("#deactivate-user").attr('data-id', data.id);
      }
    })
  });

  $(document).on('click', '#deactivate-user', function(){
    $.ajax({
      url: "{{ route('user.deactivate_user') }}",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $('#modal-deactivate-user').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        $('#user-table').DataTable().ajax.reload();
      }
    })
  });
</script>
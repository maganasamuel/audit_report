<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
  integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
  crossorigin="anonymous"></script>
<script>
  function fetch_data() {
    $('#adviser-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('adviser.fetch_data') }}",
      columns: [{
          data: 'id',
          name: 'id',
          "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
            $(nTd).addClass('text-center');
          }
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'fsp_no',
          name: 'fsp_no'
        },
        {
          data: 'status',
          name: 'status',
          "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
            if (oData.status == "Terminated") {
              $(nTd).html(
                '<span class="badge bg-danger text-white">Terminated</span>'
              );
            } else {
              $(nTd).html(
                '<span class="badge bg-success text-white">Active</span>'
              );
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
      createdRow: function(row, data, dataIndex) {
        if (data['status'] == "Terminated") {
          $(row).css('backgroundColor', '#ffc8d3');
        }
      }
    });
  }

  $(document).ready(function() {
    fetch_data();
  });

  var token = $('input[name="_token"]').val();

  $(document).on('adviser-created', function(event) {
    $('#add-adviser').modal('hide');
    $('#success').removeClass('d-none');
    $('#success').addClass('d-block');
    $('#success-text').text(event.detail);
    $('#adviser-table').DataTable().ajax.reload();
  })

  $(document).on('click', '#edit-adviser', function() {
    $.ajax({
      url: "{{ route('adviser.edit_adviser') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr("data-id"),
        _token: token,
      },
      success: function(data) {
        $('#edit_name').val(data.name);
        $('#edit_fsp_no').val(data.fsp_no);
        $('#update_adviser').attr('data-id', data.id);
      }
    })
  });

  $(document).on('click', '#update_adviser', function() {
    $('#update_adviser').find('i').removeClass('d-none');
    $('#update_adviser').find('i').addClass('d-inline-block');
    $(this).prop('disabled', true);
    var updated_name = $('#edit_name').val();
    var updated_fsp_no = $('#edit_fsp_no').val();

    if (updated_name != '' && updated_fsp_no != '') {
      $.ajax({
        url: "{{ route('adviser.update_adviser') }}",
        method: "POST",
        data: {
          id: $(this).attr('data-id'),
          name: updated_name,
          fsp_no: updated_fsp_no,
          _token: token
        },
        success: function(data) {
          $('#update_adviser').prop('disabled', false);
          $('#update_adviser').find('i').removeClass(
            'd-inline-block');
          $('#update_adviser').find('i').addClass('d-none');
          $('#modal-edit-adviser').modal('hide');
          $('#success').removeClass('d-none');
          $('#success').addClass('d-block');
          $('#success-text').text(data);
          $('#adviser-table').DataTable().ajax.reload();
        }
      })
    } else {
      $('#edit_name').val('');
      $('#edit_fsp_no').val('');
      $('#modal-edit-adviser').modal('hide');
      $('#error').removeClass('d-none');
      $('#error').addClass('d-block');
      $('#danger-text').text('Both fields are required to have a value.');
    }
  });

  $(document).on('click', '#adviser-deactivate-confirmation', function() {
    $.ajax({
      url: "{{ route('adviser.confirm_adviser_deactivate') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data) {
        $("#deactivate-adviser-name").text(data.name);
        $("#deactivate-adviser").attr('data-id', data.id);
      }
    })
  });

  $(document).on('click', '#deactivate-adviser', function() {
    $('#deactivate-adviser').find('i').removeClass('d-none');
    $('#deactivate-adviser').find('i').addClass('d-inline-block');
    $(this).prop('disabled', true);

    $.ajax({
      url: "{{ route('adviser.deactivate_adviser') }}",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data) {
        $('#deactivate-adviser').find('i').removeClass('d-none');
        $('#deactivate-adviser').find('i').addClass('d-inline-block');
        $('#deactivate-adviser').prop('disabled', true);
        $('#modal-deactivate-adviser').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        $('#adviser-table').DataTable().ajax.reload();
      }
    })
  });

</script>

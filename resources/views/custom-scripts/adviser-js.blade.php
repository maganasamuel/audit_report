<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  function fetch_data(){
    $.ajax({
      url: "/advisercontroller/fetch_data",
      dataType: "json",
      success: function(data){

        var html = '';
        if(data.length != 0){
          $.each(data, function(index, value){
            (data[index].status == "Terminated") ? html += '<tr style="background-color: #ffcad4">': html += '<tr>';
            
            html += '<td class="text-center">'+ (index+1) +'</td>';
            html += '<td>'+ data[index].name +'</td>';
            html += '<td>'+ data[index].fsp_no +'</td>';
            html += '<td>'+ data[index].status +'</td>';
            html += '<td class="td-actions text-left"><button type="button" id="edit-adviser" rel="tooltip" class="btn btn-success btn-icon btn-sm" data-id="'+ data[index].id +'" data-original-title="" title="" data-toggle="modal" data-target="#modal-edit-adviser"><i class="fa fa-edit pt-1"></i></button><button type="button" id="deactivate-confirmation" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="" data-id="'+ data[index].id +'" data-toggle="modal" data-target="#modal-deactivate-adviser"><i class="fa fa-ban pt-1"></i></button></td>';
            html += '<tr>';
          });
        } else {
          html += '<tr>';
          html +='<td colspan="5" class="text-center">No data found.</td>';
          html += '</tr>';
        }
        
        $('tbody').html(html);
      }
    })
  }

  $(document).ready(function(){
    fetch_data();
  });

  var token = $('input[name="_token"]').val();

  $(document).on('click', '#add', function(){
    var name = $('#name').val();
    var fsp_no = $('#fsp_no').val();
    
    if(name != '' && fsp_no != ''){
      $.ajax({
        url: "{{ route('adviser.new_adviser') }}",
        method: "POST",
        data: {
          name: name,
          fsp_no: fsp_no,
          _token: token,
        },
        success: function(data){
          $('#name').val('');
          $('#fsp_no').val('');
          $('#add-adviser').modal('hide');
          $('#success').removeClass('d-none');
          $('#success').addClass('d-block');
          $('#success-text').text(data);
          fetch_data();
        }
      })
    } else {
      $('#name').val('');
      $('#fsp_no').val('');
      $('#add-adviser').modal('hide');
      $('#error').removeClass('d-none');
      $('#error').addClass('d-block');
      $('#danger-text').text('Both fields are required to have a value.');
    }
  });

  $(document).on('click', '#edit-adviser', function(){
    $.ajax({
      url: "{{ route('adviser.edit_adviser')}}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr("data-id"),
        _token: token,
      },
      success: function(data){
        $('#edit_name').val(data.name);
        $('#edit_fsp_no').val(data.fsp_no);
        $('#update_adviser').attr('data-id', data.id);
      }
    })
  });

  $(document).on('click', '#update_adviser', function(){
    var updated_name = $('#edit_name').val();
    var updated_fsp_no = $('#edit_fsp_no').val();

    if(updated_name != '' && updated_fsp_no != ''){
      $.ajax({
        url: "{{ route('adviser.update_adviser') }}",
        method: "POST",
        data: {
          id: $(this).attr('data-id'),
          name: updated_name,
          fsp_no: updated_fsp_no,
          _token: token
        },
        success: function(data){
          $('#modal-edit-adviser').modal('hide');
          $('#success').removeClass('d-none');
          $('#success').addClass('d-block');
          $('#success-text').text(data);
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

  $(document).on('click', '#deactivate-confirmation', function(){
    $.ajax({
      url: "{{ route('adviser.confirm_deactivate') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $("#deactivate-adviser-name").text(data.name);
        $("#deactivate-adviser").attr('data-id', data.id);
      }
    })
  });

  $(document).on('click', '#deactivate-adviser', function(){
    $.ajax({
      url: "{{ route('adviser.deactivate_adviser') }}",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $('#modal-deactivate-adviser').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        fetch_data();
      }
    })
  });
</script>
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
            html += '<tr>';
            html += '<td class="text-center">'+ (index+1) +'</td>';
            html += '<td>'+ data[index].name +'</td>';
            html += '<td>'+ data[index].fsp_no +'</td>';
            html += '<td>'+ data[index].status +'</td>';
            html += '<td class="td-actions text-left"><button type="button" id="delete-adviser" rel="tooltip" class="btn btn-success btn-icon btn-sm" data-id="'+ data[index].id +'" data-original-title="" title=""><i class="fa fa-edit pt-1"></i></button><button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title=""><i class="fa fa-trash pt-1"></i></button></td>';
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
      $('#danger-text').text('Both fields are required to have a value.')
    }
  });
</script>
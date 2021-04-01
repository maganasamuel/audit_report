<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  $(document).ready(function(){
    var token = $('input[name="_token"]').val();
    $('#advisers').select2();

    $('#advisers').on('select2:select', function(e){
      var id = $(this).val();

      $.ajax({
        url: "{{ route('reports.fetch_adviser') }}",
        method: "POST",
        data: {
          id,
          _token: token
        },
        success: function(data){
          $('#fsp_no').val(data.fsp_no);
        }
      });
    });

  });

</script>
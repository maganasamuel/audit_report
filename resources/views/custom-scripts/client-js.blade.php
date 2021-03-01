<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  function fetch_data(){
    $('#client-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('client.fetch_data') }}",
        columns: [
          { data: 'id', name: 'id',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).addClass('text-center');
             }
          },
          { data: 'policy_holder', name: 'policy_holder'},
          { data: 'policy_no', name: 'policy_no'},
          {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
          },
        ],
        createdRow: function(row, data, dataIndex){
          if(data['status'] == "Terminated"){
            $(row).css('backgroundColor', '#ffc8d3');
          }
         }
      });
  }

  $(document).ready(function(){
    fetch_data();
  });

  $(document).on('click', '#view-client-pdf', function(){
    $.ajax({
      url: "{{ route('pdfs.view_pdf') }}",
      data: {
        id: $(this).attr("data-id")
      },
      success: function(data){
        console.log(data);
      }
    })
  });


</script>
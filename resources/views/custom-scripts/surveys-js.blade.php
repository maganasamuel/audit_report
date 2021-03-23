<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  var token = $('input[name="_token"]').val();
  function fetch_data(){
    $('#survey-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('surveys.fetch_data') }}",
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
            searchable: true,
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).addClass('d-flex');
             }
          },
        ],
      });
  }

  $(document).ready(function(){
    fetch_data();
  });
</script>
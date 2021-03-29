<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  var token = $('input[name="_token"]').val();
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
            searchable: true,
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).addClass('d-block');
             }
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

  

  $(document).on('click', '#edit-client', function(){
    
    $.ajax({
      url: "{{ route('pdfs.edit_pdf') }}",
      data: {
        id: $(this).attr('data-id')
      },
      success: function(data){
        $.each(data.advisers, function(index, adviser){
          $('#adviser').append(new Option(adviser.name, adviser.id))
        });

        $('#week-of').val(data.weekOf);
        $('#adviser > option').each(function(){
          if(this.value == data.adviser.id){
            $(`option[value=${data.adviser.id}]`).attr('selected', 'selected');
          }
        });
        $('#lead_source > option').each(function(){
          if(this.value == data.clients.audits[0].pivot.lead_source){
            $(`option[value=${data.clients.audits[0].pivot.lead_source}]`).attr('selected', 'selected');
          }
        });

        $('#policy_holder').val(data.clients.policy_holder);
        $('#policy_no').val(data.clients.policy_no);

        $('.questions').each(function(index, question){
          $(this).val(data.answers[index]);
        })

        $('#updateAudit').attr('data-client', data.clients.id);
        $('#updateAudit').attr('data-audit', data.clients.audits[0].id);
        $('#updateAudit').attr('data-adviser', $('#adviser').find('option:selected').val());
        $('#adviser').on('change', function(){
          $('#updateAudit').attr('data-adviser', $(this).find('option:selected').val());
        })
        
      }
    })
  });

  $(document).on('click', '#updateAudit', function(e){
    e.preventDefault();

    var weekOf = $('#week-of').val();
    var adviser = $('#adviser').val();
    var lead_source = $('#lead_source').val();
    var policy_holder = $('#policy_holder').val();
    var policy_no = $('#policy_no').val();
    var client_id = $(this).attr('data-client');
    var audit_id = $(this).attr('data-audit');
    var adviser_id = $(this).attr('data-adviser');

    let qa = {};

    qa.questions=[];
    qa.answers=[];
    $('.questions').each(function(x,y){
      qa.questions.push($(this).siblings('label').html());    
      qa.answers.push($(this).val());

    });

    $.ajax({
      url: "{{ route('pdfs.update_pdf') }}",
      method: "POST",
      data: {
        c_id: client_id,
        au_id: audit_id,
        ad_id: adviser_id,
        weekOf: weekOf,
        adviser: adviser,
        lead_source: lead_source,
        policy_holder: policy_holder,
        policy_no: policy_no,
        qa: qa,
        _token: token
      },
      success: function(data){
        $('#client-table').DataTable().ajax.reload();
        $('#edit-client-pdf-modal').modal('hide');
        if(data == "The file doesn't exists"){
          $('#success').removeClass('d-none');
          $('#success').addClass('d-block');
          $('#success-text').text(data);
        } else {
          $('#error').removeClass('d-none');
          $('#error').addClass('d-block');
          $('#danger-text').text(data);
        }
        $('#adviser').val('');
        $('#lead_source').val('');
        $('#policy_holder').val('');
        $('#policy_no').val('');

        $('.questions').each(function(x,y){    
          $(this).val('');
        });
        $('html, body').animate({
          scrollTop: $("#navbar-main").offset().top
        }, 1);
      }
    })
  });

  $(document).on('click', '#client-delete-confirmation', function(){
    $.ajax({
      url: "{{ route('pdfs.confirm_client_delete') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $("#delete-client-name").text(data.policy_holder);
        $("#delete-client").attr('data-id', data.id);
        $("#delete-client").attr('data-audit', data.audits[0].id);
      }
    })
  });

  $(document).on('click', '#delete-client', function(){
    $.ajax({
      url: "{{ route('pdfs.delete_client') }}",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        audit_id: $(this).attr('data-audit'),
        _token: token
      },
      success: function(data){
        $('#modal-delete-client').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        $('#client-table').DataTable().ajax.reload();
      }
    })
  });

</script>
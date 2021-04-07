<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>


<script>
  console.log($().jquery);

  $('#client-question').on('change', function(){
    let choice = $(this).children('option:selected').val();

    if(choice == "Yes"){
      ($('#new')) ? $('#new').remove() : "";
      ($('#current')) ? $('#current').remove() : "";
      
      $('#if-new-client').append($('<div class="row" id="new"><div class="form-group col-lg-6 col-md-12"><input type="text" name="policy_holder" placeholder="Policy Holder" class="form-email form-control" id="policy_holder" required></div><div class="form-group col-lg-6 col-md-12"><input type="text" name="policy_no" id="policy_no" placeholder="Policy No" class="form-control" required></div></div>').hide().fadeIn(500));
    } else {
      
      ($('#new')) ? $('#new').remove() : "";
      ($('#current')) ? $('#current').remove() : "";
      $('#if-new-client').append($('<div class="row" id="current"><div class="form-group col-lg-6 col-md-12"><select id="old_policy_holder" name="policy_holder" class="form-control"><option value="" selected disabled>Choose an option</option></select></div><div class="form-group col-lg-6 col-md-12"><input type="text" name="policy_no" id="old_policy_no" placeholder="Policy No" class="form-control" required disabled></div></div>').hide().fadeIn(500));
      $.ajax({
        url: "{{ route('calls.fetch_clients') }}",
        success: function(data){
          data.forEach(function(client, index){
            $('#old_policy_holder').append(`<option value='${client.id}' data-num='${client.policy_no}'>${client.policy_holder}</option>`);
            $('#old_policy_holder').on('change', function(){
              let choice = $(this).children('option:selected').val();

              if(choice == client.id){
                $('#old_policy_no').val(client.policy_no);
              }
            });
          });
        }
      });
      $('#old_policy_holder').select2();
    }
  });
  
  $('#submitAudit').on('click', function(e) {
    e.preventDefault();
    $('#submitAudit').find('i').removeClass('d-none');
    $('#submitAudit').find('i').addClass('d-inline-block');
    $(this).prop('disabled', true);

    const token = $('input[name="_token"]').val();
    var weekOf = $('#week-of').val();
    var adviser = $('#adviser').val();
    var lead_source = $('#lead_source').val();
    var policy_holder = $('#policy_holder').val();
    var old_policy_holder = $('#old_policy_holder').val();
    var policy_no = $('#policy_no').val();

    let qa = {};

    qa.questions=[];
    qa.answers=[];
    
    $('.questions').each(function(x,y){
      qa.questions.push($(this).siblings('label').html());    
      qa.answers.push($(this).val());

    });

    $.ajax({

      url: "{{ route('calls.store_audit')}}",
      method: "POST",
      data: {
        weekOf: weekOf,
        adviser: adviser,
        lead_source: lead_source,
        policy_holder: policy_holder,
        policy_no: policy_no,
        old_policy_holder,
        qa: qa,
        _token: token
      },
      success: function(data){
        $('#submitAudit').find('i').removeClass('d-inline-block');
        $('#submitAudit').find('i').addClass('d-none');
        $('#submitAudit').prop('disabled', false);
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
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

  $(document).ready(function () {
    $('#adviser').select2();
    
    $('.registration-form fieldset:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function () {
      $(this).removeClass('input-error');
    });

    // next step
    $('.registration-form .btn-next').on('click', function () {
      var parent_fieldset = $(this).parents('fieldset');
      var next_step = true;

      parent_fieldset.find('input[type="text"],input[type="email"]').each(function () {
        if ($(this).val() == "") {
          $(this).addClass('input-error');
          next_step = false;
        } else {
          $(this).removeClass('input-error');
        }
      });

      if (next_step) {
        parent_fieldset.fadeOut(400, function () {
          $(this).next().fadeIn();
        });
      }

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function () {
      $(this).parents('fieldset').fadeOut(400, function () {
        $(this).prev().fadeIn();
      });
    });

    // submit
    $('.registration-form').on('submit', function (e) {

      $(this).find('input[type="text"],input[type="email"]').each(function () {
        if ($(this).val() == "") {
          e.preventDefault();
          $(this).addClass('input-error');
        } else {
          $(this).removeClass('input-error');
        }
      });

    });


  });
</script>
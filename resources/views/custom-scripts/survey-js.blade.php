<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
  integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
  crossorigin="anonymous"></script>

<script>
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = dd + '-' + mm + '-' + yyyy;

  $(document).on('survey-created', function(event){
    $('#success').removeClass('d-none');
    $('#success').addClass('d-block');
    $('#success-text').text(event.detail);
  });

  $(document).on('click', '#edit-survey', function() {
    setInterval(function() {
      if ($('#submit-btn').length != 0) {
        $('#submit-btn').remove();
        $('#updateSurvey').addClass('d-block');
        $('#updateSurvey').removeClass('d-none');
      }
    }, 1);

    $.ajax({
      url: "{{ route('pdfs.edit_survey') }}",
      data: {
        id: $(this).attr('data-id')
      },
      success: function(data) {
        $('#updateSurvey').attr('data-survey', data.survey.id);
        $.each(data.advisers, function(i, val) {
          if (data.adviser.id == val.id) {
            $('#adviser-edit').append(
              `<option value=${val.id} selected>${val.name}</option>`
            );
          } else {
            $('#adviser-edit').append(
              `<option value=${val.id}>${val.name}</option>`);
          }
        });
        $('#week-of-edit').val(data.survey_date);
      }
    });
  });

  $(document).on('click', '#updateSurvey', function(e) {
    e.preventDefault();
    $('#updateSurvey').find('i').removeClass('d-inline-block');
    $('#updateSurvey').find('i').addClass('d-none');
    $('#updateSurvey').prop('disabled', true);
    const token = $('input[name="_token"]').val();
    var weekOf = $('#week-of-edit').val();
    var adviser = $('#adviser-edit').val();
    var survey_id = $(this).attr('data-survey');

    let sa = {};
    sa.questions = [];
    sa.answers = [];
    $('.survey-qa').each(function(x, y) {
      sa.questions.push($(this).children('label').html());
      sa.answers.push($(this).children('label').siblings().val());
    });

    $.ajax({
      url: "{{ route('pdfs.update_survey') }}",
      method: "POST",
      data: {
        weekOf,
        adviser,
        sa,
        survey_id,
        _token: token
      },
      success: function(data) {
        $('#updateSurvey').find('i').removeClass('d-none');
        $('#updateSurvey').find('i').addClass('d-inline-block');
        $('#updateSurvey').prop('disabled', false);
        $('#edit-survey-pdf-modal').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        ($('#week-of')) ? $('#week-of').val(today): "";
        ($('#adviser')) ? $('#adviser').val(""): "";
        ($('#policy_holder')) ? $('#policy_holder').val(""): "";
        ($('#policy_no')) ? $('#policy_no').val(""): "";
        ($('#level-2')) ? $('#level-2').remove(): "";
        ($('#level-3')) ? $('#level-3').remove(): "";
        ($('#level-4')) ? $('#level-4').remove(): "";
        ($('#level-5')) ? $('#level-5').remove(): "";
        ($('#level-6')) ? $('#level-6').remove(): "";
        ($('#level-7-yes')) ? $('#level-7-yes').remove(): "";
        ($('#level-7-no')) ? $('#level-7-no').remove(): "";
        ($('#level-7')) ? $('#level-7').remove(): "";
        ($('#level-8')) ? $('#level-8').remove(): "";
        ($('#level-6-no')) ? $('#level-6-no').remove(): "";
        ($('#last-question')) ? $('#last-question').remove(): "";
        ($('#submit-btn')) ? $('#submit-btn').remove(): "";
        $('.questions').each(function(x, y) {
          $(this).children('label').siblings().val('');
        });
        $('html, body').animate({
          scrollTop: $("#navbar-main").offset().top
        }, 1);
        setTimeout(function() {
          location.reload();
        }, 3000);
      }
    });
  });

  $(document).on('click', '#survey-cancel-confirmation', function() {
    $.ajax({
      url: "{{ route('pdfs.confirm_cancel_survey') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data) {
        $('#cancel-survey').attr('data-id', data.id);
        $('#cancel_client_name').text(data.policy_holder);
      }

    });
  });

  $(document).on('click', '#cancel-survey', function() {
    $.ajax({
      url: "{{ route('pdfs.cancel_survey') }}",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data) {
        $('#modal-cancel-survey').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        $('#client-table').DataTable().ajax.reload();
      }

    })
  });

</script>

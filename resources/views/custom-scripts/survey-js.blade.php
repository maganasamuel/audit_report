<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = dd + '-' + mm + '-' + yyyy;

  $(document).ready(function(){
    $('#adviser').select2();
    $('#old_policy_holder').select2();
  });
  
  $('#client-question').on('change', function(){
    let choice = $(this).children('option:selected').val();

    if(choice == "Yes"){
      ($('#new')) ? $('#new').remove() : "";
      ($('#current')) ? $('#current').remove() : "";

      $('#if-new-client').append($('<div class="row" id="new"><div class="form-group col-lg-6 col-md-12"><input type="text" name="policy_holder" placeholder="Policy Holder" class="form-email form-control" id="policy_holder" required></div><div class="form-group col-lg-6 col-md-12"><input type="text" name="policy_no" id="policy_no" placeholder="Policy No" class="form-control" required></div></div>').hide().fadeIn(500));
    } else {
      ($('#new')) ? $('#new').remove() : "";
      ($('#current')) ? $('#current').remove() : "";
      $('#if-new-client').append($('<div class="row" id="current"><div class="form-group col-lg-6 col-md-12"><select id="policy_holder" name="policy_holder" class="form-control"><option value="" selected disabled>Choose an option</option></select></div><div class="form-group col-lg-6 col-md-12"><input type="text" name="policy_no" id="policy_no" placeholder="Policy No" class="form-control" required disabled></div></div>').hide().fadeIn(500));
      $.ajax({
        url: "{{ route('calls.fetch_clients') }}",
        success: function(data){
          data.forEach(function(client, index){
            $('#policy_holder').append(`<option value='${client.policy_holder}' data-num='${client.policy_no}'>${client.policy_holder}</option>`);
            $('#policy_holder').on('change', function(){
              let choice = $(this).children('option:selected').val();
              if(choice == client.policy_holder){
                $('#policy_no').val(client.policy_no);
              }
            });
          });
        }
      });
      $('#policy_holder').select2();
    }
  });

  $('#level-1').on('change', function(){
    let choice = $(this).children('option:selected').val();

    if(choice == "Yes"){
      ($('#level-3')) ? $('#level-3').remove() : "";
      ($('#level-4')) ? $('#level-4').remove() : "";
      ($('#level-5')) ? $('#level-5').remove() : "";
      ($('#level-6')) ? $('#level-6').remove() : "";
      ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
      ($('#level-7-no')) ? $('#level-7-no').remove() : "";
      ($('#level-7')) ? $('#level-7').remove() : "";
      ($('#level-8')) ? $('#level-8').remove() : "";
      ($('#level-6-no')) ? $('#level-6-no').remove() : "";
      ($('#last-question')) ? $('#last-question').remove() : "";
      ($('#submit-btn')) ? $('#submit-btn').remove() : "";

      $('.card-body.survey').append($(
        '<div class="form-group survey-qa" id="level-2"><label>Who is your Adviser?</label><input type="text" class="form-control" id="secondlevel-yes"></div>').hide().fadeIn(1000)
      );
      $('#secondlevel-yes').focus();
    } else {
        ($('#level-2')) ? $('#level-2').remove() : "";
        ($('#level-3')) ? $('#level-3').remove() : "";
        ($('#level-4')) ? $('#level-4').remove() : "";
        ($('#level-5')) ? $('#level-5').remove() : "";
        ($('#level-6')) ? $('#level-6').remove() : "";
        ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
        ($('#level-7-no')) ? $('#level-7-no').remove() : "";
        ($('#level-7')) ? $('#level-7').remove() : "";
        ($('#level-8')) ? $('#level-8').remove() : "";
        ($('#level-6-no')) ? $('#level-6-no').remove() : "";
        ($('#last-question')) ? $('#last-question').remove() : "";
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";
      $('.card-body.survey').append($(
        '<div class="form-group survey-qa" id="level-3"><label>Are you replacing your Partners Life Policy with one at another Provider?</label><select id="secondlevel-no" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
      );
      $('#secondlevel-no').focus();
    }

    $('#secondlevel-yes').on('change', function(){
      if($(this).val()){
        ($('#level-3')) ? $('#level-3').remove() : "";
        ($('#level-4')) ? $('#level-4').remove() : "";
        ($('#level-5')) ? $('#level-5').remove() : "";
        ($('#level-6')) ? $('#level-6').remove() : "";
        ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
        ($('#level-7')) ? $('#level-7').remove() : "";
        ($('#level-8')) ? $('#level-8').remove() : "";
        ($('#level-6-no')) ? $('#level-6-no').remove() : "";
        ($('#last-question')) ? $('#last-question').remove() : "";
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";

        $('.card-body.survey').append($(
          '<div class="form-group survey-qa" id="level-3"><label>Are you replacing your Partners Life Policy with one at another Provider?</label><select id="thirdlevel-yes-right" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
        );
      } else {
        ($('#level-3')) ? $('#level-3').remove() : "";
        ($('#level-4')) ? $('#level-4').remove() : "";
        ($('#level-5')) ? $('#level-5').remove() : "";
        ($('#level-6')) ? $('#level-6').remove() : "";
        ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
        ($('#level-7')) ? $('#level-7').remove() : "";
        ($('#level-8')) ? $('#level-8').remove() : "";
        ($('#level-6-no')) ? $('#level-6-no').remove() : "";
        ($('#last-question')) ? $('#last-question').remove() : "";
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";
        
      }

      $('#thirdlevel-yes-right').on('change', function(){
        let choice = $(this).children('option:selected').val();

        if(choice == "Yes"){
          ($('#level-4')) ? $('#level-4').remove() : "";
          ($('#level-5')) ? $('#level-5').remove() : "";
          ($('#level-6')) ? $('#level-6').remove() : "";
          ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
          ($('#level-7')) ? $('#level-7').remove() : "";
          ($('#level-8')) ? $('#level-8').remove() : "";
          ($('#level-6-no')) ? $('#level-6-no').remove() : "";
          ($('#last-question')) ? $('#last-question').remove() : "";
          ($('#submit-btn')) ? $('#submit-btn').remove() : "";
          $('.card-body.survey').append($(
            '<div class="form-group survey-qa" id="level-4"><label>Did your Adviser explain the differences between your Partners Life Policy and your new replacement insurance Policy?</label><select id="thirdlevel-yes-no-1" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
          );
            
          $('#thirdlevel-yes-no-1').on('change', function(){
            ($('#level-5')) ? $('#level-5').remove() : "";
            ($('#level-6')) ? $('#level-6').remove() : "";
            ($('#level-7')) ? $('#level-7').remove() : "";
            ($('#level-8')) ? $('#level-8').remove() : "";
            ($('#level-6-no')) ? $('#level-6-no').remove() : "";
            ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
            ($('#level-8')) ? $('#level-8').remove() : "";
            ($('#last-question')) ? $('#last-question').remove() : "";
            ($('#submit-btn')) ? $('#submit-btn').remove() : "";

            $('.card-body.survey').append($(
            '<div class="form-group survey-qa" id="level-5"><label>Did your Adviser explain the risk of Non-Disclosure or Misstatement to you?</label><select id="thirdlevel-yes-no-2" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
            );

            $('#thirdlevel-yes-no-2').on('change', function(){
              ($('#level-6')) ? $('#level-6').remove() : "";
              ($('#level-7')) ? $('#level-7').remove() : "";
              ($('#level-8')) ? $('#level-8').remove() : "";
              ($('#level-6-no')) ? $('#level-6-no').remove() : "";
              ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
              ($('#level-8')) ? $('#level-8').remove() : "";
              ($('#last-question')) ? $('#last-question').remove() : "";
              ($('#submit-btn')) ? $('#submit-btn').remove() : "";

              $('.card-body.survey').append($(
              '<div class="form-group survey-qa" id="level-6"><label>Did your Adviser discuss both the benefits you forefit and any risks you might be exposed to in cancelling your cover from us?</label><select id="thirdlevel-yes-no-3" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
              );

              $('#thirdlevel-yes-no-3').on('change', function(){
                ($('#level-7-no')) ? $('#level-7-no').remove() : "";
                ($('#level-7')) ? $('#level-7').remove() : "";
                ($('#level-8')) ? $('#level-8').remove() : "";
                ($('#level-6-no')) ? $('#level-6-no').remove() : "";
                ($('#last-question')) ? $('#last-question').remove() : "";
                ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
                ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                $('.card-body.survey').append($(
                  '<div class="form-group survey-qa" id="level-7-yes"><label>Why are you cancelling your Policy with us?</label><input type="text" class="form-control" id="thirdlevel-yes"></div>').hide().fadeIn(1000)
                );

                $('#thirdlevel-yes').on('change', function(){
                  ($('#last-question')) ? $('#last-question').remove() : "";
                  ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                  if($(this).val()){
                    if($('#level-8')){
                      $('#level-8').remove();
                        $('.card-body.survey').append($(
                          '<div class="form-group survey-qa" id="level-8"><label>Who is your new insurer?</label><input type="text" class="form-control" id="eightlevel-no"></div>').hide().fadeIn(1000)
                        );
                      }
                  } else {
                    $('#level-8').remove();
                    ($('#last-question')) ? $('#last-question').remove() : "";
                  }

                  $('#level-8').on('change', function(){
                    ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                    if($('#eightlevel-no').val()){
                      if($('#last-question')){
                        $('#last-question').remove();
                        $('.card-body.survey').append($(
                          '<div class="form-group survey-qa" id="last-question"><label>What could we do to improve?</label><input type="text" class="form-control" id="lastquestion"></div>').hide().fadeIn(1000)
                        );
                      }
                    } else {
                      $('#last-question').remove();
                    }

                    $('#last-question').on('change', function(){
                      if($('#lastquestion').val()){
                        if($('#submit-btn')){
                          $('#submit-btn').remove();
                            $('.card-body.survey').append($(
                              '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn"><i class="fa fa-circle-o-notch fa-spin d-none m-1" style="font-size: 10px;"></i>Submit</button></div>').hide().fadeIn(1000)
                            );
                          }
                        } else {
                          $('#submit-btn').remove();
                        }

                        $('#submit-btn').on('click', function(e){
                          // console.log(e);
                          $('#submit-btn').find('i').removeClass('d-inline-block');
                          $('#submit-btn').find('i').addClass('d-none');
                          $('#submit-btn').prop('disabled', true);
                          e.preventDefault();
                          let sa = {};
                          sa.questions = [];
                          sa.answers = [];
                          const token = $('input[name="_token"]').val();
                          const dateToday = $('#week-of').val();
                          const adviser = $('#adviser').val();
                          const policy_holder = $('#policy_holder').val();
                          const policy_no = $('#policy_no').val();


                          $('.survey-qa').each(function(x, y){
                            sa.questions.push($(this).children('label').html());
                            sa.answers.push($(this).children('label').siblings().val());
                          });

                          $.ajax({
                            url: "{{ route('calls.store_survey') }}",
                            method: "POST",
                            data: {
                              survey: sa,
                              date_today: dateToday,
                              adviser,
                              policy_holder,
                              policy_no,
                              _token: token
                            },
                            success: function(data){
                              $('#submit-btn').find('i').removeClass('d-none');
                              $('#submit-btn').find('i').addClass('d-inline-block');
                              $('#submit-btn').prop('disabled', false);
                              $('#success').removeClass('d-none');
                              $('#success').addClass('d-block');
                              $('#success-text').text(data);
                              ($('#week-of')) ? $('#week-of').val(today) : "";
                              ($('#adviser')) ? $('#adviser').val("") : "";
                              ($('#policy_holder')) ? $('#policy_holder').val("") : "";
                              ($('#policy_no')) ? $('#policy_no').val("") : "";
                              ($('#level-2')) ? $('#level-2').remove() : "";
                              ($('#level-3')) ? $('#level-3').remove() : "";
                              ($('#level-4')) ? $('#level-4').remove() : "";
                              ($('#level-5')) ? $('#level-5').remove() : "";
                              ($('#level-6')) ? $('#level-6').remove() : "";
                              ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
                              ($('#level-7-no')) ? $('#level-7-no').remove() : "";
                              ($('#level-7')) ? $('#level-7').remove() : "";
                              ($('#level-8')) ? $('#level-8').remove() : "";
                              ($('#level-6-no')) ? $('#level-6-no').remove() : "";
                              ($('#last-question')) ? $('#last-question').remove() : "";
                              ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                              $('.questions').each(function(x,y){    
                                $(this).children('label').siblings().val('');
                              });
                              $('html, body').animate({
                                scrollTop: $("#navbar-main").offset().top
                              }, 1);
                              setTimeout(function(){
                                location.reload();
                              }, 3000);
                            }
                          });
                        });
                    });
                  });//level-8
                });//thirdlevel-yes
              });//thirdlevel-yes-no-3
            });//thirdlevel-yes-no-2
          });//thirdlevel-yes-no-1
        } else {
          ($('#level-4')) ? $('#level-4').remove() : "";
          ($('#level-5')) ? $('#level-5').remove() : "";
          ($('#level-6')) ? $('#level-6').remove() : "";
          ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
          ($('#level-7')) ? $('#level-7').remove() : "";
          ($('#level-8')) ? $('#level-8').remove() : "";
          ($('#level-6-no')) ? $('#level-6-no').remove() : "";
          ($('#last-question')) ? $('#last-question').remove() : "";
          ($('#submit-btn')) ? $('#submit-btn').remove() : "";
          $('.card-body.survey').append($(
            '<div class="form-group survey-qa" id="level-6-no"><label>Did your Adviser discuss both the benefits you forfeit and any risks you might be exposed to in cancelling your cover from us?</label><select id="thirdlevel-no-right" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
          );

          $('#thirdlevel-no-right').on('change', function(){
            ($('#level-5')) ? $('#level-5').remove() : "";
            ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
            ($('#level-7-no')) ? $('#level-7-no').remove() : "";
            ($('#level-7')) ? $('#level-7').remove() : "";
            ($('#submit-btn')) ? $('#submit-btn').remove() : "";
            ($('#level-8')) ? $('#level-8').remove() : "";
            ($('#last-question')) ? $('#last-question').remove() : "";
            $('.card-body.survey').append($(
              '<div class="form-group survey-qa" id="level-7"><label>Why are you cancelling your Policy with us?</label><input type="text" class="form-control" id="seventhlevel-yes"></div>').hide().fadeIn(1000)
            );

            $('#seventhlevel-yes').on('change', function(){
              ($('#submit-btn')) ? $('#submit-btn').remove() : "";
              if($(this).val()){
                if($('#last-question')){
                    $('#last-question').remove();
                    $('.card-body.survey').append($(
                      '<div class="form-group survey-qa" id="last-question"><label>What could we do to improve?</label><input type="text" class="form-control" id="lastquestion"></div>').hide().fadeIn(1000)
                    );
                  }
              } else {
                // $('#level-8').remove();
                ($('#last-question')) ? $('#last-question').remove() : "";
              }


              // $('#level-8').on('change', function(){
              //   ($('#submit-btn')) ? $('#submit-btn').remove() : "";
              //   if($('#eightlevel-no').val()){
              //     if($('#last-question')){
              //       $('#last-question').remove();
              //       $('.card-body.survey').append($(
              //         '<div class="form-group survey-qa" id="last-question"><label>What could we do to improve?</label><input type="text" class="form-control" id="lastquestion"></div>').hide().fadeIn(1000)
              //       );
              //     }
              //   } else {
              //     $('#last-question').remove();
              //   }

                $('#last-question').on('change', function(){
                  if($('#lastquestion').val()){
                    if($('#submit-btn')){
                      $('#submit-btn').remove();
                        $('.card-body.survey').append($(
                          '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn"><i class="fa fa-circle-o-notch fa-spin d-none m-1" style="font-size: 10px;"></i>Submit</button></div>').hide().fadeIn(1000)
                        );
                      }
                    } else {
                      $('#submit-btn').remove();
                    }
                    $('#submit-btn').on('click', function(e){
                      // console.log(e);
                      $('#submit-btn').find('i').removeClass('d-inline-block');
                      $('#submit-btn').find('i').addClass('d-none');
                      $('#submit-btn').prop('disabled', true);
                      e.preventDefault();
                      let sa = {};
                      sa.questions = [];
                      sa.answers = [];
                      const token = $('input[name="_token"]').val();
                      const dateToday = $('#week-of').val();
                      const adviser = $('#adviser').val();
                      const policy_holder = $('#policy_holder').val();
                      const policy_no = $('#policy_no').val();

                      $('.survey-qa').each(function(x, y){
                        sa.questions.push($(this).children('label').html());
                        sa.answers.push($(this).children('label').siblings().val());
                      });

                      $.ajax({
                        url: "{{ route('calls.store_survey') }}",
                        method: "POST",
                        data: {
                          survey: sa,
                          date_today: dateToday,
                          adviser,
                          policy_holder,
                          policy_no,
                          _token: token
                        },
                        success: function(data){
                          $('#submit-btn').find('i').removeClass('d-none');
                          $('#submit-btn').find('i').addClass('d-inline-block');
                          $('#submit-btn').prop('disabled', false);
                          $('#success').removeClass('d-none');
                          $('#success').addClass('d-block');
                          $('#success-text').text(data);
                          ($('#week-of')) ? $('#week-of').val(today) : "";
                          ($('#adviser')) ? $('#adviser').val("") : "";
                          ($('#policy_holder')) ? $('#policy_holder').val("") : "";
                          ($('#policy_no')) ? $('#policy_no').val("") : "";
                          ($('#level-2')) ? $('#level-2').remove() : "";
                          ($('#level-3')) ? $('#level-3').remove() : "";
                          ($('#level-4')) ? $('#level-4').remove() : "";
                          ($('#level-5')) ? $('#level-5').remove() : "";
                          ($('#level-6')) ? $('#level-6').remove() : "";
                          ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
                          ($('#level-7-no')) ? $('#level-7-no').remove() : "";
                          ($('#level-7')) ? $('#level-7').remove() : "";
                          ($('#level-8')) ? $('#level-8').remove() : "";
                          ($('#level-6-no')) ? $('#level-6-no').remove() : "";
                          ($('#last-question')) ? $('#last-question').remove() : "";
                          ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                          $('.questions').each(function(x,y){    
                            $(this).children('label').siblings().val('');
                          });
                          $('html, body').animate({
                            scrollTop: $("#navbar-main").offset().top
                          }, 1);
                          setTimeout(function(){
                            location.reload();
                          }, 3000);
                        }
                      });
                    });
                });
              });
            })
          }
      });//thirdlevel-yes-right
    });//secondlevel-yes
    

    $('#secondlevel-no').on('change', function(){

      let choice = $(this).children('option:selected').val();

      if(choice == 'Yes'){
        ($('#level-7-no')) ? $('#level-7-no').remove() : "";
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";
        $('.card-body.survey').append($(
          '<div class="form-group survey-qa" id="level-7-yes"><label>Why are you cancelling your Policy with us?</label><input type="text" class="form-control" id="thirdlevel-yes"></div>').hide().fadeIn(1000)
        );
      } else {
        ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";
        $('.card-body.survey').append($(
          '<div class="form-group survey-qa" id="level-7-no"><label>Why are you cancelling your Policy with us?</label><input type="text" class="form-control" id="thirdlevel-no"></div>').hide().fadeIn(1000)
        );
      }

      $('#thirdlevel-yes').on('change', function(){
        if($(this).val()){
          ($('#submit-btn')) ? $('#submit-btn').remove() : "";
          if($('#level-8')){
            $('#level-8').remove();
            $('.card-body.survey').append($(
              '<div class="form-group survey-qa" id="level-8"><label>Who is your new insurer?</label><input type="text" class="form-control" id="eightlevel-no"></div>').hide().fadeIn(1000)
            );
          }
        } else {
          $('#level-8').remove()
        }

        $('#level-8').on('change', function(){
          ($('#submit-btn')) ? $('#submit-btn').remove() : "";
          if($('#eightlevel-no').val()){
            if($('#last-question')){
              $('#last-question').remove();
              $('.card-body.survey').append($(
                '<div class="form-group survey-qa" id="last-question"><label>What could we do to improve?</label><input type="text" class="form-control" id="lastquestion"></div>').hide().fadeIn(1000)
              );
            }
          } else {
            $('#last-question').remove()
          }

          $('#last-question').on('change', function(){
            if($('#lastquestion').val()){
              if($('#submit-btn')){
                $('#submit-btn').remove();
                  $('.card-body.survey').append($(
                    '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn"><i class="fa fa-circle-o-notch fa-spin d-none m-1" style="font-size: 10px;"></i>Submit</button></div>').hide().fadeIn(1000)
                  );
                }
              } else {
                $('#submit-btn').remove();
              }
              $('#submit-btn').on('click', function(e){
                // console.log(e);
                $('#submit-btn').find('i').removeClass('d-inline-block');
                $('#submit-btn').find('i').addClass('d-none');
                $('#submit-btn').prop('disabled', true);
                e.preventDefault();
                let sa = {};
                sa.questions = [];
                sa.answers = [];
                const token = $('input[name="_token"]').val();
                const dateToday = $('#week-of').val();
                const adviser = $('#adviser').val();
                const policy_holder = $('#policy_holder').val();
                const policy_no = $('#policy_no').val();

                $('.survey-qa').each(function(x, y){
                  sa.questions.push($(this).children('label').html());
                  sa.answers.push($(this).children('label').siblings().val());
                });

                $.ajax({
                  url: "{{ route('calls.store_survey') }}",
                  method: "POST",
                  data: {
                    survey: sa,
                    date_today: dateToday,
                    adviser,
                    policy_holder,
                    policy_no,
                    _token: token
                  },
                  success: function(data){
                    $('#submit-btn').find('i').removeClass('d-none');
                    $('#submit-btn').find('i').addClass('d-inline-block');
                    $('#submit-btn').prop('disabled', false);
                    $('#success').removeClass('d-none');
                    $('#success').addClass('d-block');
                    $('#success-text').text(data);
                    ($('#week-of')) ? $('#week-of').val(today) : "";
                    ($('#adviser')) ? $('#adviser').val("") : "";
                    ($('#policy_holder')) ? $('#policy_holder').val("") : "";
                    ($('#policy_no')) ? $('#policy_no').val("") : "";
                    ($('#level-2')) ? $('#level-2').remove() : "";
                    ($('#level-3')) ? $('#level-3').remove() : "";
                    ($('#level-4')) ? $('#level-4').remove() : "";
                    ($('#level-5')) ? $('#level-5').remove() : "";
                    ($('#level-6')) ? $('#level-6').remove() : "";
                    ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
                    ($('#level-7-no')) ? $('#level-7-no').remove() : "";
                    ($('#level-7')) ? $('#level-7').remove() : "";
                    ($('#level-8')) ? $('#level-8').remove() : "";
                    ($('#level-6-no')) ? $('#level-6-no').remove() : "";
                    ($('#last-question')) ? $('#last-question').remove() : "";
                    ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                    $('.questions').each(function(x,y){    
                      $(this).children('label').siblings().val('');
                    });
                    $('html, body').animate({
                      scrollTop: $("#navbar-main").offset().top
                    }, 1);
                    setTimeout(function(){
                      location.reload();
                    }, 3000);
                  }
                });
              });
          });
        });//end of level-8
      });//end of thirdlevel-yes

      $('#thirdlevel-no').on('change', function(){
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";
        if($(this).val()){
          if($('#last-question')){
            $('#last-question').remove();
            $('.card-body.survey').append($(
              '<div class="form-group survey-qa" id="last-question"><label>What could we do to improve?</label><input type="text" class="form-control" id="lastquestion"></div>').hide().fadeIn(1000)
            );
          }
        } else {
          $('#last-question').remove()
        }
        $('#last-question').on('change', function(){
          if($('#lastquestion').val()){
            if($('#submit-btn')){
              $('#submit-btn').remove();
                $('.card-body.survey').append($(
                  '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn"><i class="fa fa-circle-o-notch fa-spin d-none m-1" style="font-size: 10px;"></i>Submit</button></div>').hide().fadeIn(1000)
                );
              }
            } else {
              $('#submit-btn').remove();
            }
            $('#submit-btn').on('click', function(e){
              // console.log(e);
              $('#submit-btn').find('i').removeClass('d-inline-block');
              $('#submit-btn').find('i').addClass('d-none');
              $('#submit-btn').prop('disabled', true);
              e.preventDefault();
              let sa = {};
              sa.questions = [];
              sa.answers = [];
              const token = $('input[name="_token"]').val();
              const dateToday = $('#week-of').val();
              const adviser = $('#adviser').val();
              const policy_holder = $('#policy_holder').val();
              const policy_no = $('#policy_no').val();

              $('.survey-qa').each(function(x, y){
                sa.questions.push($(this).children('label').html());
                sa.answers.push($(this).children('label').siblings().val());
              });

              $.ajax({
                url: "{{ route('calls.store_survey') }}",
                method: "POST",
                data: {
                  survey: sa,
                  date_today: dateToday,
                  adviser,
                  policy_holder,
                  policy_no,
                  _token: token
                },
                success: function(data){
                  $('#submit-btn').find('i').removeClass('d-none');
                  $('#submit-btn').find('i').addClass('d-inline-block');
                  $('#submit-btn').prop('disabled', false);
                  $('#success').removeClass('d-none');
                  $('#success').addClass('d-block');
                  $('#success-text').text(data);
                  ($('#week-of')) ? $('#week-of').val(today) : "";
                  ($('#adviser')) ? $('#adviser').val("") : "";
                  ($('#policy_holder')) ? $('#policy_holder').val("") : "";
                  ($('#policy_no')) ? $('#policy_no').val("") : "";
                  ($('#level-2')) ? $('#level-2').remove() : "";
                  ($('#level-3')) ? $('#level-3').remove() : "";
                  ($('#level-4')) ? $('#level-4').remove() : "";
                  ($('#level-5')) ? $('#level-5').remove() : "";
                  ($('#level-6')) ? $('#level-6').remove() : "";
                  ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
                  ($('#level-7-no')) ? $('#level-7-no').remove() : "";
                  ($('#level-7')) ? $('#level-7').remove() : "";
                  ($('#level-8')) ? $('#level-8').remove() : "";
                  ($('#level-6-no')) ? $('#level-6-no').remove() : "";
                  ($('#last-question')) ? $('#last-question').remove() : "";
                  ($('#submit-btn')) ? $('#submit-btn').remove() : "";
                  $('.questions').each(function(x,y){    
                    $(this).children('label').siblings().val('');
                  });
                  $('html, body').animate({
                    scrollTop: $("#navbar-main").offset().top
                  }, 1);
                  setTimeout(function(){
                    location.reload();
                  }, 3000);
                }
              });
            });
        });
      });//end of third-no
      
    });//end of second-no
    
  });//end of first

  $(document).on('click', '#edit-survey', function(){
    setInterval(function(){
      if($('#submit-btn').length != 0){
        $('#submit-btn').remove();
        $('#updateSurvey').addClass('d-block');
        $('#updateSurvey').removeClass('d-none');
      }
    }, 1);

    $.ajax({
      url: "{{ route('pdfs.edit_survey')}}",
      data: {
        id: $(this).attr('data-id')
      },
      success: function(data){
        $('#updateSurvey').attr('data-survey', data.survey.id);
        $.each(data.advisers, function(i, val){
          if(data.adviser.id == val.id){
            $('#adviser-edit').append(`<option value=${val.id} selected>${val.name}</option>`);
          } else {
            $('#adviser-edit').append(`<option value=${val.id}>${val.name}</option>`);
          }
        });
        $('#week-of-edit').val(data.survey_date);
      }
    });
  });

  $(document).on('click', '#updateSurvey', function(e){
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
    $('.survey-qa').each(function(x, y){
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
      success: function(data){
        $('#updateSurvey').find('i').removeClass('d-none');
        $('#updateSurvey').find('i').addClass('d-inline-block');
        $('#updateSurvey').prop('disabled', false);
        $('#edit-survey-pdf-modal').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        ($('#week-of')) ? $('#week-of').val(today) : "";
        ($('#adviser')) ? $('#adviser').val("") : "";
        ($('#policy_holder')) ? $('#policy_holder').val("") : "";
        ($('#policy_no')) ? $('#policy_no').val("") : "";
        ($('#level-2')) ? $('#level-2').remove() : "";
        ($('#level-3')) ? $('#level-3').remove() : "";
        ($('#level-4')) ? $('#level-4').remove() : "";
        ($('#level-5')) ? $('#level-5').remove() : "";
        ($('#level-6')) ? $('#level-6').remove() : "";
        ($('#level-7-yes')) ? $('#level-7-yes').remove() : "";
        ($('#level-7-no')) ? $('#level-7-no').remove() : "";
        ($('#level-7')) ? $('#level-7').remove() : "";
        ($('#level-8')) ? $('#level-8').remove() : "";
        ($('#level-6-no')) ? $('#level-6-no').remove() : "";
        ($('#last-question')) ? $('#last-question').remove() : "";
        ($('#submit-btn')) ? $('#submit-btn').remove() : "";
        $('.questions').each(function(x,y){    
          $(this).children('label').siblings().val('');
        });
        $('html, body').animate({
          scrollTop: $("#navbar-main").offset().top
        }, 1);
        setTimeout(function(){
          location.reload();
        }, 3000);
      }
    });
  });

  $(document).on('click', '#survey-cancel-confirmation', function(){
    $.ajax({
      url: "{{ route('pdfs.confirm_cancel_survey') }}",
      dataType: "json",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $('#cancel-survey').attr('data-id', data.id);
        $('#cancel_client_name').text(data.policy_holder);
      }

    });
  });

  $(document).on('click', '#cancel-survey', function(){
    $.ajax({
      url: "{{ route('pdfs.cancel_survey') }}",
      method: "POST",
      data: {
        id: $(this).attr('data-id'),
        _token: token
      },
      success: function(data){
        $('#modal-cancel-survey').modal('hide');
        $('#success').removeClass('d-none');
        $('#success').addClass('d-block');
        $('#success-text').text(data);
        $('#client-table').DataTable().ajax.reload();
      }

    })
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  
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
                              '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn">Submit</button></div>').hide().fadeIn(1000)
                            );
                          }
                        } else {
                          $('#submit-btn').remove();
                        }

                        $('#submit-btn').on('click', function(e){
                          // console.log(e);
                          e.preventDefault();
                          let sa = {};
                          sa.questions = [];
                          sa.answers = [];
                          const token = $('input[name="_token"]').val();

                          $('.survey-qa').each(function(x, y){
                            sa.questions.push($(this).children('label').html());
                            sa.answers.push($(this).children('label').siblings().val());
                          });

                          $.ajax({
                            url: "{{ route('calls.store_survey') }}",
                            method: "POST",
                            data: {
                              survey: sa,
                              _token: token
                            },
                            success: function(data){

                              $('#success').removeClass('d-none');
                              $('#success').addClass('d-block');
                              $('#success-text').text(data);
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
                if($('#level-8')){
                  $('#level-8').remove();
                  ($('#last-question')) ? $('#last-question').remove() : "";
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
                          '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn">Submit</button></div>').hide().fadeIn(1000)
                        );
                      }
                    } else {
                      $('#submit-btn').remove();
                    }
                    $('#submit-btn').on('click', function(e){
                      // console.log(e);
                      e.preventDefault();
                      let sa = {};
                      sa.questions = [];
                      sa.answers = [];

                      $('.survey-qa').each(function(x, y){
                        sa.questions.push($(this).children('label').html());
                        sa.answers.push($(this).children('label').siblings().val());
                      });
                      console.log(sa);
                    });
                });
              });
            })
          });
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
                    '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn">Submit</button></div>').hide().fadeIn(1000)
                  );
                }
              } else {
                $('#submit-btn').remove();
              }
              $('#submit-btn').on('click', function(e){
              // console.log(e);
                e.preventDefault();
                let sa = {};
                sa.questions = [];
                sa.answers = [];

                $('.survey-qa').each(function(x, y){
                  sa.questions.push($(this).children('label').html());
                  sa.answers.push($(this).children('label').siblings().val());
                });
                console.log(sa);
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
                  '<div class="form-group text-center"><button type="button" class="btn btn-success" id="submit-btn">Submit</button></div>').hide().fadeIn(1000)
                );
              }
            } else {
              $('#submit-btn').remove();
            }
            $('#submit-btn').on('click', function(e){
              // console.log(e);
              e.preventDefault();
              let sa = {};
              sa.questions = [];
              sa.answers = [];

              $('.survey-qa').each(function(x, y){
                sa.questions.push($(this).children('label').html());
                sa.answers.push($(this).children('label').siblings().val());
              });
              console.log(sa);
            });
        });
      });//end of third-no
      
    });//end of second-no
    
  });//end of first

</script>
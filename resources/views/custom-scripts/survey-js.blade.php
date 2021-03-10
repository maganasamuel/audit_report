<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  
  $('#level-1').on('change', function(){
    let choice = $(this).children('option:selected').val();

    if(choice == "Yes"){
      ($('#level-3')) ? $('#level-3').remove() : "";
      $('.card-body.survey').append($(
        '<div class="form-group" id="level-2"><label>Who is your Adviser?</label><input type="text" class="form-control" id="second-yes"></div>').hide().fadeIn(1000)
      );
    } else {
      ($('#level-2')) ? $('#level-2').remove() : "";
      $('.card-body.survey').append($(
        '<div class="form-group" id="level-3"><label>Are you replacing your Partners Life Policy with one at another Provider?</label><select id="second-no" class="form-control"><option value="" selected disabled>Choose an option</option><option value="Yes">Yes</option><option value="No">No</option></select></div>').hide().fadeIn(1000)
      );
    }

    $('#second-no').on('change', function(){

      let choice = $(this).children('option:selected').val();

      if(choice == 'Yes'){
        ($('#no1')) ? $('#no1').remove() : "";
        $('.card-body.survey').append($(
          '<div class="form-group" id="yes1"><label>Why are you cancelling your Policy with us?</label><input type="text" class="form-control" id="third-yes"></div>').hide().fadeIn(1000)
        );
      } else {
        ($('#yes1')) ? $('#yes1').remove() : "";
        $('.card-body.survey').append($(
          '<div class="form-group" id="no1"><label>Why are you cancelling your Policy with us?</label><input type="text" class="form-control" id="third-no"></div>').hide().fadeIn(1000)
        );
      }

      $('#third-no').on('change', function(){
        if($(this).val()){
          if($('#no2')){
            $('#no2').remove();
            $('.card-body.survey').append($(
              '<div class="form-group" id="no2"><label>What could we do to improve?</label><input type="text" class="form-control" id="fourth-no"></div>').hide().fadeIn(1000)
            );
          }
        } else {
          $('#no2').remove()
        }
      });//end of third-no
      
    });//end of second-no
    
  });//end of first
</script>
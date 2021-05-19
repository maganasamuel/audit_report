<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audit Report | PDF</title>

        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 3cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 12px;
                left: 12px;
                right: 0cm;
                height: 3cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <img src="{{public_path('assets/img/logo-only.png') }}" height="100%"/>
        </header>

        <footer>
            <img src="{{public_path('assets/img/EliteInsure_Horizontal.png') }}" height="100%"/>
            <p>{{ __('www.eliteinsure.co.nz') }}</p>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div class="row mb-4">
              <div class="col-lg-6">
                  
                  {{--<img src="{{url('assets/img/EliteInsure_Horizontal.png') }}" alt="EliteInsure Logo" class="img-thumbnail">--}}

                 
              </div>
              <div class="col-lg-6 text-right">
                <div>
                  <h1 class="display-5 lead text-uppercase">{{ __('Audit Report') }}</h1>
                  <p style="font-size: 12px;">{{ $audit->pivot->pdf_title }}</p>
                </div>

                <div >
                  <p style="font-size: 12px;">{{ __('Date') }} :</p>
                  <p style="font-size: 12px;">{{ $audit->pivot->weekOf }}</p>
                </div>
                
              </div>
            </div>

            <div class="row">

              <div class="col-lg-4 text-left">
            
                  <p style="font-size: 12px;">Policy Holder: {{ $client->policy_holder }}</p>
                  <p style="font-size: 12px;">Policy Number: {{ $client->policy_no}}</p>
         
              </div>
              <div class="col-lg-4 text-center">

                  <p style="font-size: 12px;">Adiviser: {{ $audit->adviser->name}}</p>
                  <p style="font-size: 12px;">Lead Source: {{ $lead_source}}</p>
            
              </div>
              <div class="col-lg-4 text-right">
          
                  <p style="font-size: 12px;">Caller Name: {{ $audit->caller->name}}</p>
                  <p style="font-size: 12px;">Caller Email Address: {{ $audit->caller->email}}</p>
              
              </div>

            </div>

            <div class="row">
              <div class="col-lg-12">
                @foreach($questions as $key => $question)
                  <h6 class="font-weight-normal">{{ $key + 1}} . {{ $question['question'] }}</h6>
                  <p class="font-italic" style="font-size: 12px; margin-left: 4;">{{ $question['answer'] }}</p>
                @endforeach
              </div>
              
            </div>
        </main>
    </body>
</html>
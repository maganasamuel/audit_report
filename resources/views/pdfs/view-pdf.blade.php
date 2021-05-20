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
                top: 16px;
                left: 0cm;
                right: 0cm;
                height: 3cm;

            }

            /** Define the footer rules **/
            footer {
     
                position: fixed; 
                bottom: 0; 
                left: 0; 
                right: 0;
                height: 2cm;
                margin: 0 24px;
              
            }

            .title {

              color: 2e74b6;
              font-size: 28px;
              text-align: center;
            }

            .footer-div {

              display: flex;
              justify-content: space-between;
              align-self: center;
              flex-direction: row;
            }

            main p{

              font-size: 14px;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <img style="min-width:100%; object-fit:fill;" src="{{public_path('assets/img/headers_auditinsure.png') }}" width="100%" height="65%"/>
        </header>

        <footer>
            
          
            <img style="object-fit: fill; " src="{{public_path('assets/img/EliteInsure_Horizontal.png') }}" height="50%"/>
            <p style="color:2e74b6; text-align: right; margin-bottom: 24px;" >{{ __('www.eliteinsure.co.nz') }}</p>
            </div>
         
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            
            <div style="background-color:2e74b6; height: 2px;"></div>
            
            <h1  class="title">{{ __('Audit Report') }}</h1>
            <div>
              <p>{{ $audit->pivot->pdf_title }}</p>
      
              <p>{{ __('Date') }} : {{ $audit->pivot->weekOf }}</p>

              <p>Policy Holder: {{ $client->policy_holder }}</p>
              <p>Policy Number: {{ $client->policy_no}}</p>
      

              <p>Adiviser: {{ $audit->adviser->name}}</p>
              <p>Lead Source: {{ $lead_source}}</p>
        

              <p>Caller Name: {{ $audit->caller->name}}</p>
              <p>Caller Email Address: {{ $audit->caller->email}}</p>
            </div>
            <div style="background-color:2e74b6; height: 2px;"></div>

              @foreach($questions as $key => $question)
                <p style="font-size:16px;">{{ $key + 1}} . {{ $question['question'] }}</p>
                @isset($question['answer'])
                <p style="margin-left: 4; text-transform:capitalize;">{{ $question['answer'] }}</p>
                @endisset
              @endforeach
        </main>
    </body>
</html>
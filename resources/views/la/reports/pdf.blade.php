<!doctype>
<html>
  <head>
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style id="normalize">
      /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}main{display:block}h1{font-size:2em;margin:.67em 0}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}img{border-style:none}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details{display:block}summary{display:list-item}template{display:none}[hidden]{display:none}
    </style>
    <style>
      body {
        font-family: "Helvetica Neue", Arial, sans-serif;
      }
      h1,h2,h3,h4,h5,h6,a,p {
        margin: 0;
      }
      h4 {
        font-size: 18px;
      }
      p {
        font-size: 12px;
      }
      .column {
        float: left;
        width: 50%;
      }

      /* Clear floats after the columns */
      .row:after {
        content: "";
        display: table;
        clear: both;
      }
      .pdf-title {
        margin-bottom: 20px;
      }
      .text-center {
        text-align: center;
      }
      .font-weight-bold {
        font-weight: bold;
      }
      .m-0 {
        margin: 0;
      }
      .text-muted {
        color: #888;
      }
      .report-value {
        margin-left: 10px;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <h4 class="text-center pdf-title">{{ $title }}</h4>
      </div>
      
      <!-- Header -->
      @php $counter = 0 @endphp
      @foreach ($headers as $key => $header)
        @php $counter++ @endphp
        @if ($counter % 2 === 1)
          <div class="row">
        @endif
        <div class="column">
          <p class="m-0"><span class="text-muted report-key">{{ $key }}</span>: <span class="font-weight-bold report-value">{{ $header }}</span></p>
        </div>

        @if ($counter % 2 === 0)
          </div>
        @endif
      @endforeach

      <!-- Body -->

      <!-- Footer -->
    </div>
  </body>
</html>
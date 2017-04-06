<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Bill Splitter</title>
    <meta charset='utf-8'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css' rel='stylesheet'>
    <link href='css/a2.css' rel='stylesheet'>
</head>

<!-- the $quality variable needs to be accessible
even if the form has not been submitted -->
<?php $quality = $quality ?? '';?>

<body>
    <h1>Bill Splitter</h1>

    <form method='get' action='/split' class='form-horizontal'>
        <div><!--get the tab-->
            <label for='tab'>How much is the tab? $</label>
            <input type='number' name='tab' id='tab' min='0' step="0.01" value='{{$tab or ''}}' required>
            <div class='text-warning'>Required</div>
        </div>
        <div><!--get the party size-->
            <label for='partySize'>Split amongst how many? </label>
            <input type='number' name='partySize' id='partySize' min='1' value='{{$partySize or ''}}' required>
            <div class='text-warning'>Required</div>
        </div>
        <div><!--get the quality of service-->
            <label for='quality'>How was the service?</label>
            <select name='quality' id='quality'>
                <option value='bad' @if ($quality=='bad') selected @endif>Bad (15% tip)</option>
                <option value='good' @if ($quality!='excellent' and $quality!='bad') selected @endif>Good (18% tip)</option>
                <option value='excellent' @if ($quality=='excellent') selected @endif>Excellent (21% tip)</option>
            </select>
        </div>
        <div><!--round up?-->
            <label for='roundUp'>Round up?</label>
            <input type='checkbox' name='roundUp' id='roundUp' @if ($roundUp??false == true) CHECKED @endif>
        </div><!--submit-->
        <input type='submit' class='btn btn-primary' value='submit'>
    </form>

    @yield('results')

    @if(count($errors) > 0)
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
</body>
</html>

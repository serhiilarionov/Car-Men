<link rel="stylesheet" href="{{ URL::asset('assets/css/components/workTimes.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/jquery.timepicker.css') }}">

<div class="controlButtons">
    <div class="checkbox">
        <label><input type="checkbox" id="copyCheckBox">Copy</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" id="lunchCheckBox">Lunch</label>
    </div>
</div>

<div id="workTime" data-work-times="{{$company->detail['work_time']}}"></div>

<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.businessHours.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/components/workTimes.js') }}"></script>
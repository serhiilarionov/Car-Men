@section('css')
    {!! Html::style('assets/css/components/detailRepeater.css') !!}
@stop

<div class="{{$type}}Repeater" data-{{$type}}="{{json_encode($company->detail[$type])}}">
    <div data-repeater-list="{{$type}}" class="repeat-list">
        @if(count($company->detail[$type]) > 0)
            @foreach($company->detail[$type] as $key=>$value)
                <div data-repeater-item class="input-group repeat-element">
                    <input type="text" class="{{$type}} form-control" name="{{$type}}" value="{{$value}}" required>
                    <span class="input-group-btn">
                        <input class="btn btn-danger" type="button"
                               data-repeater-delete value="Delete"/>
                    </span>
                </div>
            @endforeach
        @else
            <div data-repeater-item class="input-group repeat-element">
                <input type="text" class="{{$type}} form-control" name="{{$type}}" required>
                <span class="input-group-btn">
                    <input class="btn btn-danger" type="button"
                           data-repeater-delete value="Delete"/>
                </span>
            </div>
        @endif
    </div>
    <input data-repeater-create type="button" value="Add" class="btn btn-success"/>
</div>

@section('scripts')
    {!! Html::script('assets/js/jquery.repeater.js') !!}
    {!! Html::script('assets/js/components/detailRepeater.js') !!}
@stop
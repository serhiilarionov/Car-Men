<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_detail" data-toggle="tab" aria-expanded="true">Detail</a>
            </li>
            <li>
                <a href="#tab_service" data-toggle="tab" aria-expanded="true">Service</a>
            </li>
        </ul>
        <div class="tab-content clearfix">
            <div class="tab-pane active" id="tab_detail">
                <!-- Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Parent Id Field -->
                <div class="form-group col-sm-12">
                    {!! Form::label('parent_id', 'Parent category:') !!}
                    @if(isset($category))
                        {!! Form::select('parent_id', $mainCategories->pluck('name', 'id'), $category->parent_id, ['placeholder' => 'No parent']) !!}
                    @else
                        {!! Form::select('parent_id', $mainCategories->pluck('name', 'id'), null, ['placeholder' => 'No parent']) !!}
                    @endif
                </div>

                <!-- Active Field -->
                <div class="form-group col-sm-12">
                    {!! Form::label('active', 'Active:') !!}
                    {!! Form::hidden('active', 0) !!}
                    {!! Form::checkbox('active', 1) !!}
                </div>
            </div>
            <div class="tab-pane" id="tab_service">
                <div class="col-sm-2">
                    <button type="button" class="btn btn-success btn-show-block margin">
                        <i class="fa fa-plus"></i>
                        Add Service
                    </button>
                </div>
                <div class="col-md-12 add-service-block margin">
                    {!! Form::label('service-name', 'Service name') !!}
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::text('service-name', null, ['class' => 'form-control', 'data' => isset($category) ? $category->id : null ]) !!}
                        </div>
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-success btn-add-service">OK</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-group service-list">
                    <table class="table table-striped">
                        <tbody>
                            @foreach($services as $service)
                                <tr id="service-id-{{$service->id}}">
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <label style="line-height: 32px; margin-bottom: 0;">{!! $service->name !!}</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn btn-default btn-delete-service" data="{{$service->id}}">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('catalog.categories.index') !!}" class="btn btn-default">Cancel</a>
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    $('.add-service-block').hide();
    $('.btn-show-block').click(function () {
        $('.btn-show-block').hide();
        $('.add-service-block').show();
    });
    $('.btn-add-service').click(function () {
        var categoryId = $('#service-name').attr('data');
        var serviceName = $('#service-name').val();
        $.ajax({
            type: "POST",
            data: {
                categoryId: categoryId,
                serviceName: serviceName
            },
            url: "{{route('catalog.services.createService')}}"
        }).success(function (data) {
            console.log(data);

            var bodyBlock = '<tr id="service-id-'+ data +'"><td><div class="row">'
                    +'<div class="col-sm-11">'
                    +'<label style="line-height: 32px; margin-bottom: 0;">'+ serviceName +'</label>'
                    +'</div>'
                    +'<div class="col-sm-1">'
                    +'<button type="button" class="btn btn-default btn-delete-service" data="'+ data +'">'
                    +'<i class="glyphicon glyphicon-trash"></i></button> </div> </div></td></tr>'

            $('.add-service-block').hide();
            $('.add-service-block #service-name').val('');
            $('.btn-show-block').show();
            $(bodyBlock).prependTo('.service-list tbody');

        });
    });

    $(document).on('click', '.btn-delete-service', function () {
        var serviceId = $(this).attr('data');
        $.ajax({
            type: "delete",
            data: {
                serviceId: serviceId
            },
            url: "{{route('catalog.services.deleteService')}}"
        }).success(function () {
            $('.service-list #service-id-'+ serviceId).remove();
        });
    });
</script>
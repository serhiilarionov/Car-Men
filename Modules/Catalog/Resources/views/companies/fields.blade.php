<!-- Tabs -->
<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_company" data-toggle="tab" aria-expanded="true">User info</a>
            </li>
            <li>
                <a href="#tab_detail" data-toggle="tab" aria-expanded="true">Details</a>
            </li>
            <li>
                <a href="#tab_comfort" data-toggle="tab" aria-expanded="true">Comforts</a>
            </li>
            <li>
                <a href="#tab_category" data-toggle="tab" aria-expanded="true">Categories</a>
            </li>
            <li>
                <a href="#tab_service" data-toggle="tab" aria-expanded="true">Services</a>
            </li>
            <li>
                <a href="#tab_rating" data-toggle="tab" aria-expanded="true">Company rating</a>
            </li>
        </ul>
        <div class="tab-content clearfix">
            <div class="tab-pane active" id="tab_company">

                <!-- Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- City Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('city_id', 'City Id:') !!}
                    @if(isset($category))
                        {!! Form::select('city_id', $cities->pluck('name', 'id'), $category->parent_id,
                        ['placeholder' => 'No city', 'class' => 'form-control']) !!}
                    @else
                        {!! Form::select('city_id', $cities->pluck('name', 'id'), null,
                        ['placeholder' => 'No city', 'class' => 'form-control']) !!}
                    @endif
                </div>

                <!-- Latitude Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('point[lat]', 'Lat:') !!}
                    {!! Form::text('point[lat]', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Longitude Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('point[lng]', 'Lng:') !!}
                    {!! Form::text('point[lng]', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Address Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('address', 'Address:') !!}
                    {!! Form::text('address', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Short Desc Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('short_desc', 'Short Desc:') !!}
                    {!! Form::text('short_desc', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Picture Field -->
                {{--<div class="form-group col-sm-6">--}}
                    {{--{!! Form::label('picture', 'Picture:') !!}--}}
                    {{--{!! Form::text('picture', null, ['class' => 'form-control']) !!}--}}
                {{--</div>--}}

                <!-- Rating Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('rating', 'Rating:') !!}
                    {!! Form::number('rating', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Price Rel Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('price_rel', 'Price Rel:') !!}
                    {!! Form::number('price_rel', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="tab-pane" id="tab_detail">
                <!-- Phones Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('phones', 'Phones:') !!}
                    @include('catalog::components.detailRepeater', ['type' => 'phones'])
                    <input type="hidden" id="phones" name="detail[phones]">
                </div>

                <!-- Website Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('website', 'Website:') !!}
                    @include('catalog::components.detailRepeater', ['type' => 'website'])
                    <input type="hidden" id="website" name="detail[website]">
                </div>

                <!-- Email Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('email', 'Email:') !!}
                    @include('catalog::components.detailRepeater', ['type' => 'email'])
                    <input type="hidden" id="email" name="detail[email]">
                </div>

                <!-- Desc Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('desc', 'Desc:') !!}
                    {!! Form::text('detail[desc]', null, ['class' => 'form-control', 'require' => true]) !!}
                </div>

                <!-- Company Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('company_id', 'Company Id:') !!}
                    {!! Form::number('detail[company_id]', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>

                <!-- Work Time Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('work_time', 'Work Time:') !!}
                    @include('catalog::components.workTimes')
                    <input type="hidden" id="work_time" name="detail[work_time]">
                </div>
            </div>
            <div class="tab-pane" id="tab_comfort">
                <div class="col-md-12">
                    <h3>Comforts</h3>
                </div>
                <div class="col-md-12 form-group">
                    @foreach($comforts as $comfort)
                        <div class="checkbox">
                            <label>
                                @if(isset($company->comforts))
                                    @if(in_array($comfort->id, $company->comforts->pluck('id')->toArray()))
                                        {!! Form::checkbox("comforts[]", $comfort->id, 1) !!}
                                    @else
                                        {!! Form::checkbox("comforts[]", $comfort->id, 0) !!}
                                    @endif
                                @else
                                    {!! Form::checkbox("comforts[]", $comfort->id, 0) !!}
                                @endif
                                {!! $comfort->name !!}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="tab_category">
                <div class="col-md-12">
                    <h3>Categories</h3>
                </div>
                <div class="col-md-12 form-group">
                    @foreach($categories as $category)
                        @if($category->parent_id == '')
                            <div class="checkbox primary-cat" data="{!! $category->id !!}">
                        @else
                            <div class="checkbox sub-cat" data="{!! $category->parent_id !!}">
                        @endif
                            <label>
                                @if(isset($company->categories))
                                    @if(in_array($category->id, $company->categories->pluck('id')->toArray()))
                                        {!! Form::checkbox("categories[]", $category->id, 1) !!}
                                    @else
                                        {!! Form::checkbox("categories[]", $category->id, 0) !!}
                                    @endif
                                @else
                                    {!! Form::checkbox("categories[]", $category->id, 0) !!}
                                @endif
                                {!! $category->name !!}
                            </label>
                            @if($category->parent_id == '')
                                <span class="alert-message">If select subcategory, must be selected primary category for subcategory</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="tab_service">
                <div class="col-md-12">
                    <h3>Services</h3>
                </div>
                <div class="col-md-12 form-group">
                    @foreach($services as $service)
                        <div class="checkbox">
                            <label>
                                @if(isset($company))
                                    @if(in_array($service->id, $company->services->pluck('id')->toArray()))
                                        {!! Form::checkbox("services[]", $service->id, 1) !!}
                                    @else
                                        {!! Form::checkbox("services[]", $service->id, 0) !!}
                                    @endif
                                @else
                                    {!! Form::checkbox("services[]", $service->id, 0) !!}
                                @endif
                                {!! $service->name !!}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="tab_rating">
                <section class="content-header">
                    <h1 class="pull-left">Company Ratings</h1>
                    <h1 class="pull-right">
                        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('catalog.companyRatings.create') !!}">Add New</a>
                    </h1>
                </section>
                <div class="content">
                    <div class="clearfix"></div>
                    @include('flash::message')
                    <div class="clearfix"></div>
                    <div class="box-primary">
                        <div class="box-body">
                            <table id="example" class="display" cellspacing="0" width="100%"></table>
                        </div>
                    </div>
                </div>
                <script>
                        $(document).ready(function() {
                            var full_url = document.URL; // Get current url
                            var url_array = full_url.split('/'); // Split the string into an array with / as separator
                            var id = url_array[url_array.length-2];  // Get the last part of the array (-1)

                            var table = $('#example').DataTable({
                                "bPaginate": true,
                                "bJQueryUI": true,
                                "iDisplayLength": 50,
                                "sPaginationType": "full_numbers",
                                'dom': 'Bfrtip',
                                'scrollX': false,
                                'buttons' : [
                                    'print',
                                    'reset',
                                    'reload',
                                    {
                                        'extend': 'collection',
                                        'text': '<i class="fa fa-download"></i> Export',
                                        'buttons': [
                                            'csv',
                                            'excel',
                                            'pdf'
                                        ]
                                    },
                                    'colvis'
                                ],
                                "ajax": {
                                    url: '/api/v1/catalog/companies/' + id + '/ratings'
                                },
                                "columns": [
                                    { "data": 'display_name'},
                                    { "data": 'title'},
                                    { "data": 'text'},
                                    { "data": 'total_rating'},
                                    { "data": 'price_rel'},
                                    { "data": 'answer_name'},
                                    { "data": 'answer_text'},
                                    { "data": 'answer_date'}
                                ],
                                "columnDefs": [
                                    { "title": "Display Name", "targets": 0 },
                                    { "title": "Title", "targets": 1 },
                                    { "title": "Text", "targets": 2 },
                                    { "title": "Total Rating", "targets": 3 },
                                    { "title": "Price Rel", "targets": 4 },
                                    { "title": "Answer Name", "targets": 5 },
                                    { "title": "Answer Text", "targets": 6 },
                                    { "title": "Answer Date", "targets": 7 },
                                    { "title": "Action", "targets": 8,
                                        'render': function (data, type, full, meta){
                                            return '<form method="POST" action="/catalog/companyRatings/' + full.id +'" accept-charset="UTF-8">' +
                                                '<input name="_method" type="hidden" value="DELETE">' +
                                                '<input name="_token" type="hidden" value="4ncDoMSJ3bo9OrlWWhALqG4meCihpNV6ydiCaJXH">' +
                                                '<div class="btn-group">' +
                                                    '<a href="/catalog/companyRatings/' + full.id +'" class="btn btn-default btn-xs">' +
                                                        '<i class="glyphicon glyphicon-eye-open"></i>' +
                                                    '</a>' +
                                                    '<a href="/catalog/companyRatings/' + full.id +'/edit" class="btn btn-default btn-xs">' +
                                                        '<i class="glyphicon glyphicon-edit"></i>' +
                                                    '</a>' +
                                                    '<button type="submit" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure?\')">' +
                                                        '<i class="glyphicon glyphicon-trash"></i>' +
                                                    '</button>' +
                                                '</div>' +
                                            '</form>';
                                        }
                                    }
                                ]
                            });
                        });
                </script>
            </div>
        </div>
    </div>
</div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'companySubmit']) !!}
        <a href="{!! route('catalog.companies.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>
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
        </ul>
        <div class="tab-content clearfix">
            <div class="tab-pane active" id="tab_company">
                <!-- Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('id', 'Id:') !!}
                    <p>{!! $company['id'] !!}</p>
                </div>
                <!-- Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('name', 'Name:') !!}
                    <p>{!! $company['name'] !!}</p>
                </div>

                <!-- City Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('city', 'City:') !!}
                    <p>{!! $city['name'] !!}</p>
                </div>

                <!-- Address Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('address', 'Address:') !!}
                    <p>{!! $company['address'] !!}</p>
                </div>

                <!-- Point Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('point', 'Point:') !!}
                    <p>{!! $company['point']['lat'] . ', ' . $company['point']['lng'] !!}</p>
                </div>

                <!-- Short Desc Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('short_desc', 'Short Desc:') !!}
                    <p>{!! $company['short_desc'] !!}</p>
                </div>

                <!-- Picture Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('picture', 'Picture:') !!}
                    @if(is_array($company->picture))
                        @foreach($company->picture as $picture)
                            <p>{!! $picture !!}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Rating Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('rating', 'Rating:') !!}
                    <p>{!! $company['rating'] !!}</p>
                </div>

                <!-- Price Rel Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('price_rel', 'Price Rel:') !!}
                    <p>{!! $company['price_rel'] !!}</p>
                </div>
            </div>
            <div class="tab-pane" id="tab_detail">
                <!-- Phones Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('phones', 'Phones:') !!}
                    @if(is_array($company->detail['phones']))
                        @foreach($company->detail['phones'] as $phone)
                            <p>{!! $phone !!}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Email Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('email', 'Email:') !!}
                    @if(is_array($company->detail['email']))
                        @foreach($company->detail['email'] as $email)
                            <p>{!! $email !!}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Website Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('website', 'Website:') !!}
                    @if(is_array($company->detail['website']))
                        @foreach($company->detail['website'] as $website)
                            <p>{!! $website !!}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Desc Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('desc', 'Desc:') !!}
                    <p>{!! $company->detail['desc'] !!}</p>
                </div>

                <!-- Work Time Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('work_time', 'Work Time:') !!}
                    <div>
                        @include('catalog::components.workTimes')
                    </div>
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
                                @if(isset($company))
                                    @if(in_array($comfort->id, $company->comforts->pluck('id')->toArray()))
                                        {!! Form::checkbox("comforts[]", $comfort->id, 1, ['disabled']) !!}
                                    @else
                                        {!! Form::checkbox("comforts[]", $comfort->id, 0, ['disabled']) !!}
                                    @endif
                                @else
                                    {!! Form::checkbox("comforts[]", $comfort->id, 0, ['disable']) !!}
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
                        <div class="checkbox">
                            <label>
                                @if(isset($company))
                                    @if(in_array($category->id, $company->categories->pluck('id')->toArray()))
                                        {!! Form::checkbox("categories[]", $category->id, 1, ['disabled']) !!}
                                    @else
                                        {!! Form::checkbox("categories[]", $category->id, 0, ['disabled']) !!}
                                    @endif
                                @else
                                    {!! Form::checkbox("categories[]", $category->id, 0, ['disabled']) !!}
                                @endif
                                {!! $category->name !!}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
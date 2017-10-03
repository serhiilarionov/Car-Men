
<!-- Tabs -->
<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_info" data-toggle="tab" aria-expanded="true">User info</a>
            </li>
            <li>
                <a href="#tab_role" data-toggle="tab" aria-expanded="true">Role</a>
            </li>
        </ul>
        <div class="tab-content clearfix">
            <div class="tab-pane active" id="tab_info">
                <!-- Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Email Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Password Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('password', 'Password:') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="tab-pane" id="tab_role">
                <div class="col-md-12 form-group">
                    @foreach($roles as $role)
                        <div class="checkbox">
                            <label>
                                @if(isset($user))
                                    @if(in_array($role->id, $user->roles->pluck('id')->toArray()))
                                        {!! Form::checkbox("roles[]", $role->id, 1) !!}
                                    @else
                                        {!! Form::checkbox("roles[]", $role->id, 0) !!}
                                    @endif
                                @else
                                    {!! Form::checkbox("roles[]", $role->id, 0) !!}
                                @endif
                                {!! $role->name !!}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('auth.users.index') !!}" class="btn btn-default">Cancel</a>
</div>

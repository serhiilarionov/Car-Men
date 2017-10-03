<li class="treeview {{ Request::is('catalog*') ? 'active' : '' }}">
    <a href="javascript:void(0)"><i class="fa fa-building"></i> Catalog</a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('catalog/cities*') ? 'active' : '' }}">
            <a href="{!! route('catalog.cities.index') !!}"><i class="fa fa-building-o"></i><span>Cities</span></a>
        </li>
        <li class="{{ Request::is('catalog/comfort*') ? 'active' : '' }}">
            <a href="{!! route('catalog.comforts.index') !!}"><i class="fa fa-edit"></i><span>Comfort</span></a>
        </li>
        <li class="{{ Request::is('catalog/categories*') ? 'active' : '' }}">
            <a href="{!! route('catalog.categories.index') !!}"><i class="fa fa-list"></i><span>Categories</span></a>
        </li>
        <li class="{{ Request::is('catalog/companies*') ? 'active' : '' }}">
            <a href="{!! route('catalog.companies.index') !!}"><i class="fa fa-industry"></i><span>Companies</span></a>
        </li>
        <li class="{{ Request::is('catalog/companyRatings*') ? 'active' : '' }}">
            <a href="{!! route('catalog.companyRatings.index') !!}"><i class="fa fa-industry"></i><span>Company ratings</span></a>
        </li>
        <li class="{{ Request::is('catalog/services*') ? 'active' : '' }}">
            <a href="{!! route('catalog.services.index') !!}"><i class="fa fa-wrench"></i><span>Services</span></a>
        </li>
    </ul>
</li>
<li class="treeview {{ Request::is('auth*') ? 'active' : '' }}">
    <a href="javascript:void(0)"><i class="fa fa-user"></i> Auth</a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('auth/users*') ? 'active' : '' }}">
            <a href="{!! route('auth.users.index') !!}"><i class="fa fa-users"></i><span>Users</span></a>
        </li>
        <li class="{{ Request::is('auth/roles*') ? 'active' : '' }}">
            <a href="{!! route('auth.roles.index') !!}"><i class="fa fa-user-secret"></i><span>Roles</span></a>
        </li>
        <li class="{{ Request::is('auth/pushLogs*') ? 'active' : '' }}">
            <a href="{!! route('auth.pushLogs.index') !!}"><i class="fa fa-user-secret"></i><span>Pushes</span></a>
        </li>
    </ul>
</li>
<li class="treeview {{ Request::is('news*') ? 'active' : '' }}">
    <a href="javascript:void(0)"><i class="fa fa-user"></i> News</a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('news/articles*') ? 'active' : '' }}">
            <a href="{!! route('news.articles.index') !!}"><i class="fa fa-users"></i><span>Articles</span></a>
        </li>
        <li class="{{ Request::is('news/parsings*') ? 'active' : '' }}">
            <a href="{!! route('news.parsings.index') !!}"><i class="fa fa-users"></i><span>Parsings</span></a>
        </li>
    </ul>
</li>

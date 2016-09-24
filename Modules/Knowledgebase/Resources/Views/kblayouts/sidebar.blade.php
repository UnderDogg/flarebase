@section('Tools')
    class="active"
@stop
@section('tools-bar')
    active
@stop
@section('kb')
    class="active"
@stop
@section('sidebar')
    <li class="header">KNOWLEDGE BASE</li>
    <li class="treeview @yield('category')">
        <a href="#">
            <i class="fa fa-list-ul"></i> <span>{{Lang::get('knowledgebase::lang.category')}}</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li @yield('add-category')><a href="{{url('/kbpanel/kbcategories/create')}}"><i
                            class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.addcategory')}}</a></li>
            <li @yield('all-category')><a href="{{url('/kbpanel/kbcategories/')}}"><i
                            class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.allcategory')}}</a></li>
        </ul>
    </li>
    <li class="treeview @yield('article')">
        <a href="#">
            <i class="fa fa-edit"></i> <span>{{Lang::get('knowledgebase::lang.articles')}}</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li @yield('add-article')><a href="{{url('/kbpanel/article/create')}}"><i
                            class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.addarticle')}}</a></li>
            <li @yield('all-article')><a href="{{url('/kbpanel/articles')}}"><i
                            class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.allarticles')}}</a></li>
        </ul>
    </li>
    <li class="treeview @yield('pages')">
        <a href="#">
            <i class="fa fa-file-text"></i> <span>{{Lang::get('knowledgebase::lang.pages')}}</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li @yield('add-pages')><a href="{{url('/kbpanel/kbpages/create')}}"><i
                            class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.addpage')}}</a></li>
            <li @yield('all-pages')><a href="{{url('/kbpanel/pages')}}"><i
                            class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.allpages')}}
                </a></li>
        </ul>
    </li>


    <li class="treeview" @yield('tags')>
        <a href="#">
    <i class="fa fa-file-text"></i> <span>{{Lang::get('knowledgebase::lang.tags')}}</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li @yield('add-tags')><a href="{{url('/kbpanel/kbtags/create')}}"><i
                        class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.addtag')}}</a></li>
        <li @yield('all-tags')><a href="{{url('/kbpanel/kbtags')}}"><i
                        class="fa fa-circle-o"></i> {{Lang::get('knowledgebase::lang.alltags')}}
            </a></li>
    </ul>
    </li>

    <li @yield('settings')>
        <a href="{{url('kb/settings')}}">
            <i class="fa fa-wrench"></i>
            <span>{{Lang::get('knowledgebase::lang.settings')}}</span>
        </a>
    </li>
@stop
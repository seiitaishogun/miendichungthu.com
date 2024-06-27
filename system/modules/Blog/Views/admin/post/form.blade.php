<div class="row">
    <div class="col-lg-8">
        @component('components.block')
            @slot('title', trans('language.basic_info'))
                <div class="form-bordered">

                    <ul class="nav nav-tabs" data-toggle="tabs">
                        @foreach(config('cnv.languages') as $language)
                            <li {{ $loop->first ? 'class=active' : '' }}>
                                <a href="#{{ $language['locale'] }}">
                                    {{ $language['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach(config('cnv.languages') as $language)
                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $language['locale'] }}">
                                <div class="form-group">
                                    {!! Form::label('name', trans('language.name'), ['class' => 'label-control']) !!}
                                    {!! Form::text('language['. $language['locale'] .'][name]', @$post->language('name', $language['locale']), ['class' => 'form-control', 'required']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name', trans('blog::language.tags'), ['class' => 'label-control']) !!}
                                    {!! Form::text('language['. $language['locale'] .'][tags]', @$post->language('tags', $language['locale']), ['class' => 'form-control input-tags']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('description', trans('language.description'), ['class' => 'label-control']) !!}
                                    {!! Form::textarea('language['. $language['locale'] .'][description]', @$post->language('description', $language['locale']), ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('description', trans('language.content'), ['class' => 'label-control']) !!}
                                    {!! Form::textarea('language['. $language['locale'] .'][content]', @$post->language('content', $language['locale']), ['class' => 'form-control editor', 'required']) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
        @endcomponent
        @include('seo_plugin::form', ['base'=>'blogs/example-category', 'model'=>$post])
        @include('custom_field::custom_fields', ['module' => 'blog', 'model' => $post])
    </div>
    <div class="col-lg-4">
        @component('components.block')
            @slot('title', trans('language.setting_field'))
                <div class="form-horizontal form-bordered">

                    {{-- <div class="form-group">
                        {!! Form::label('featured', trans('blog::language.featured'), ['class' => 'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            <label class="switch switch-warning">
                                <input type="checkbox" name="featured" value="1" {{ @$post->featured ? 'checked' : '' }}>
                                <span></span>
                            </label>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        {!! Form::label('user_id', trans('blog::language.author'), ['class' => 'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::select('user_id', get_list_authors_for_choose(), $post->user_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('published', trans('language.published'), ['class' => 'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            <label class="switch switch-primary">
                                <input type="checkbox" name="published" value="1" {{ @$post->published ? 'checked' : '' }}>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <a href="javascript:void(0);" onclick="toggleThisElement('#show_publish_datetime');return false;">{{ trans('language.set_a_specific_publish_date') }}</a>
                    </div>
                    <div class="form-group" id="show_publish_datetime" style="display: none">
                        <div class="col-md-7">
                            {!! Form::text('date_published', @$post->published_at->format('d-m-Y'), ['class' => 'form-control input-datepicker']) !!}
                        </div>
                        <div class="col-md-5">
                            <div class="input-group bootstrap-timepicker timepicker">
                                {!! Form::text('time_published', @$post->published_at->format('H:i'), ['class' => 'form-control input-timepicker24']) !!}
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div> --}}

                </div>
        @endcomponent

        <!-- BEGIN v2.1 -->
        @if(config('cnv.blog_has_address') || config('cnv.blog_has_province') || config('cnv.blog_has_district'))
            @component('components.block')
                @slot('title', trans('blog::language.others'))
                @if(config('cnv.blog_has_address'))
                <div class="form_group">
                    {!! Form::label('address', trans('blog::language.address'), ['class' => 'label-control']) !!}
                    {!! Form::text('address', @$post->address, ['class' => 'form-control']) !!}
                </div>
                @endif
                @if(config('cnv.blog_has_province'))
                <div class="form_group">
                    {!! Form::label('province', trans('blog::language.province'), ['class' => 'label-control']) !!}
                    <div id="province" data-name="{{ @$post->province ?: 0 }}"></div>
                </div>
                @endif
                @if(config('cnv.blog_has_district'))
                <div class="form_group">
                    {!! Form::label('district', trans('blog::language.district'), ['class' => 'label-control']) !!}
                    <div id="district" data-name="{{ @$post->district ?: 0 }}">
                        <select class="form-control"></select>
                    </div>
                </div>
                @endif
            @endcomponent
        @endif
        <!-- END v2.1 -->

        @component('components.block')
            @slot('title', trans('blog::language.choose_category'))
            @slot('action',
                link_to_route('admin.post.category.index', trans('blog::language.category_create'), null,
                ['class' => 'btn btn-xs btn-primary', 'target' => '_blank', 'required'])
            )

            <label>Danh mục chính</label>
            <div class="form_group">
                {!! Form::select('main_category', (
                    new \Modules\Blog\Models\PostCategory())->getParentForSelection(null, false, false),
                    @$post->main_category,
                    ['class' => 'form-control', 'multiple' => false]
                ) !!}
            </div>
            <br/>
            <label>Danh mục khác</label>
            <div class="form_group">
                {!! Form::select('category[]', (
                    new \Modules\Blog\Models\PostCategory())->getParentForSelection(null, false, false),
                    @$post->categories->map->id->toArray(),
                    ['class' => 'form-control', 'multiple' => true]
                ) !!}
            </div>

        @endcomponent
        @component('components.block')
            @slot('title', trans('language.thumbnail'))
            <div class="form_group">
                <div class="choose-thumbnail">
                    {!! Form::hidden('thumbnail', $post->thumbnail, ['id' => 'thumbnail']) !!}
                </div>
            </div>
        @endcomponent
    </div>
</div>

@include('partial.editor')

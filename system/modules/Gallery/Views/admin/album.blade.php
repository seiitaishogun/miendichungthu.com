@component('components.block')
    @slot('title', 'Album')

    <div class="form-bordered">

        <ul class="nav nav-tabs" data-toggle="tabs">
            @foreach(config('cnv.languages') as $language)
                <li {{ $loop->first ? 'class=active' : '' }}>
                    <a href="#{{ $language['locale'] }}_album">
                        {{ $language['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach(config('cnv.languages') as $language)
                @php $content = $gallery->language('content', $language['locale']) ?: collect([]); @endphp
                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $language['locale'] }}_album">

                    <div class="text-right">
                        <button class="btn btn-success btn-new-image" type="button" id="add-new-image" data-lang="{{ $language['locale'] }}">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>

                    <div class="row">
                        <div class="draggable-blocks ui-sortable {{ $language['locale'] }}-gallery-container"
                        id="images_{{ $language['locale'] }}" data-max-key="{{ $content->count() }}">
                        @php $i = $content->count() ? $content->count() - 1 : 0; @endphp
                        @foreach($content as $item)
                        <div class="image-item col-md-2 col-sm-2 col-xs-2">
                            <img src="{{ @$item['picture'] }}" alt="">
                            <div class="modal fade" id="{{ 'content_' . $i . '_' . $language['locale'] }}_edit" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">
                                                {{ trans('language.info_image') }}
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                {!! Form::label('description', trans('language.title'), ['class' => 'label-control']) !!}
                                                {!! Form::text('language['.$language['locale'].'][content]['.$i.'][title]', @$item['title'], ['class' => 'form-control', 'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('description', trans('language.description'), ['class' => 'label-control']) !!}
                                                {!! Form::textarea('language['.$language['locale'].'][content]['.$i.'][description]', @$item['description'], ['class' => 'form-control', 'rows' => 5]) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('link', trans('language.link'), ['class' => 'label-control']) !!}
                                                {!! Form::text('language['.$language['locale'].'][content]['.$i.'][link]', @$item['link'], ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('language.close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-action btn-success btn-xs edit-image" type="button" data-toggle="modal" data-target="#{{ 'content_' . $i . '_' . $language['locale'] }}_edit">
                                <i class="fa fa-pencil"></i> <span class="sr-only">edit</span>
                            </button>
                            <button class="btn btn-action btn-danger btn-xs delete-image" type="button">
                                <i class="fa fa-trash-o"></i> <span class="sr-only">delete</span>
                            </button>
                            {!! Form::hidden('language['.$language['locale'].'][content]['.$i.'][picture]', @$item['picture'], ['id' => 'content_' . $i . '_' . $language['locale']]) !!}
                        </div>
                        @php $i--; @endphp
                        @endforeach
                    </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>

@endcomponent

<div class="hidden" id="lineTemplate" data-template='
<div class="modal fade" id="content___KEY_____LANG___edit" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    {{ trans('language.info_image') }}
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('description', trans('language.title'), ['class' => 'label-control']) !!}
                    {!! Form::text('language[__LANG__][content][__KEY__][title]', '', ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', trans('language.description'), ['class' => 'label-control']) !!}
                    {!! Form::textarea('language[__LANG__][content][__KEY__][description]', '', ['class' => 'form-control', 'rows' => 5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('link', trans('language.link'), ['class' => 'label-control']) !!}
                    {!! Form::text('language[__LANG__][content][__KEY__][link]', '', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('language.close') }}</button>
            </div>
        </div>
    </div>
</div>
'></div>

<script>
    'use strict';

    var deleteButton = function () {
        var button = document.createElement('button'),
        icon = document.createElement('i'),
        txt = document.createElement('span');

        txt.setAttribute('class', 'sr-only');
        txt.innerText = 'delete';
        icon.setAttribute('class', 'fa fa-trash-o');
        button.setAttribute('class', 'btn btn-action btn-danger btn-xs delete-image');
        button.setAttribute('type', 'button');
        button.appendChild(icon);
        button.appendChild(txt);

        return button;
    },

    editButton = function (language, key) {
        var button = document.createElement('button'),
        icon = document.createElement('i'),
        txt = document.createElement('span');

        txt.setAttribute('class', 'sr-only');
        txt.innerText = 'edit';
        icon.setAttribute('class', 'fa fa-pencil');
        button.setAttribute('class', 'btn btn-action btn-success btn-xs edit-image');
        button.setAttribute('data-toggle', 'modal');
        button.setAttribute('data-target', '#content_' + key + '_' + language + '_edit');
        button.setAttribute('type', 'button');
        button.appendChild(icon);
        button.appendChild(txt);

        return button;
    },

    hiddenInput = function(url, language, key) {
        var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'language[' + language + '][content][' + key + '][picture]');
        input.setAttribute('value', url);

        return input;
    },
    createNewImageBlock = function(url, language) {
        var content = $('.' + language + '-gallery-container'),
            key = parseInt(content.data('max-key')),
            template = $('#lineTemplate').data('template');

        template = template.replace(/__KEY__/g, key);
        template = template.replace(/__LANG__/g, language);
        content.data('max-key', key + 1);

        var images = document.getElementById('images_' + language + ''),
        block = document.createElement('div'),
        image = new Image;
        image.src = url;
        block.setAttribute('class', 'image-item col-md-2 col-sm-2 col-xs-2');
        block.appendChild(image);
        block.innerHTML += template;
        block.appendChild(editButton(language, key));
        block.appendChild(deleteButton());
        block.appendChild(hiddenInput(url, language, key));
        images.appendChild(block);
    },
    UiDraggable = function() {
        return {
            init: function() {
                $(".draggable-blocks").sortable({
                    connectWith: ".image-item",
                    items: ".image-item",
                    opacity: .75,
                    handle: "img",
                    placeholder: "draggable-placeholder-gallery",
                    tolerance: "pointer",
                    start: function(e, t) {
                        t.placeholder.css("height", t.item.outerHeight())
                    }
                })
            }
        }
    }();

    UiDraggable.init();

    $('.btn-new-image').on('click', function (e) {
        e.preventDefault();
        console.log("123");

        var language = $(this).data('lang');

        moxman.browse({
            oninsert: function(args) {
                args.files.forEach(function (item, index) {
                    createNewImageBlock(item.path, language);
                });
            },
            view: 'thumbs'
        });

    });

    $(document).on('click', '.delete-image', function (event) {
        event.preventDefault();
        $(this).parent().remove();
    });
</script>

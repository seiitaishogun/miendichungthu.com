@extends('admin')

@section('page_header')

    <div class="pull-right">
        <a href="{{ admin_route('widget.index') }}" class="btn btn-default">
            <i class="fa fa-arrow-circle-left"></i> {{ trans('language.back') }}
        </a>
        <button type="button" class="btn btn-primary">
            <i class="fa fa-save"></i> {{ trans('language.save') }}
        </button>
        @if(session('save_original_content'))
            <button type="button" class="btn btn-danger save-original-content">
                <i class="fa fa-save"></i> {{ trans('widget::language.save_original') }}
            </button>
        @endif

        <button type="button" class="btn btn-warning restore-original-content">
            <i class="fa fa-undo"></i> {{ trans('widget::language.restore_original_content') }}
        </button>
    </div>

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    {!! Form::open([
        'url' => admin_route('widget.update', $widget->id),
        'method' => 'POST',
        'class' => 'form-validate',
        'id' => 'save',
        'data-callback' => 'nothing_to_do'
    ]) !!}
    {{ method_field('PUT') }}
    <input type="hidden" name="restore_original_content" value="">
    <input type="hidden" name="save_original_content" value="">
    @include('widget::form')
    {!! Form::close() !!}
@stop

@push('footer')
<script>
    $('button').click(function(e) {
        $('input[name=restore_original_content]').val('');
        $('input[name=save_original_content]').val('');
        // console.log(e.target.classList);

        if (e.target.classList.contains('save-original-content')) {
            $('input[name=save_original_content]').val('1');
        }

        if (e.target.classList.contains('restore-original-content')) {
            $('input[name=restore_original_content]').val('1');
        }

        submitForm('#save');

        setTimeout(function(){ location.reload(); }, 2000);
    });
</script>
@endpush
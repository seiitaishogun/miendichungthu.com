@extends('admin')

@section('page_header')

    @can('blog.category.create')
        <div class="pull-right">
            <a href="{{ admin_route('post.category.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('language.create') }}
            </a>
        </div>
    @endcan

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    @include('partial.datatable_mutillang', ['url' => admin_route('post.category.index')])

    @component('components.block')

        @slot('title', trans('blog::language.category_list'))

            @include('partial.datatable-nonesearch')
            @endcomponent

@stop
@push('footer')
<script type="text/javascript">
$(document).on('change', '[data-toggle="change-position"]', function (event) {
    $.ajax({
        url: CNV.baseUrl + '/iadmin/post/category/sort/' + $(this).data('id'),
        method: 'POST',
        data: {position: $(this).val()},
        dataType: 'JSON',
        success: function (data) {
            if (data.status === 200) {
                toastr.success(data.message, CNV.language.success);
                TablesDatatables.table._fnAjaxUpdate();
            } else {
                toastr.warning(data.message, CNV.language.warning);
            }
        },
        error: function(response){
            toastr.error(CNV.language.internet_error, CNV.language.error);
        }
    });
});
</script>
@endpush

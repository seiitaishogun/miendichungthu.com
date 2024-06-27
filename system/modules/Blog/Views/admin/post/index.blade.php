@extends('admin')

@section('page_header')

    @can('blog.post.create')
        <div class="pull-right">
            <a href="{{ admin_route('post.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('language.create') }}
            </a>
        </div>
    @endcan

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    @include('partial.datatable_mutillang', ['url' => admin_route('post.index')])

    @component('components.block')

        @slot('title', trans('blog::language.post_list'))

        @slot('action')
            <form action="{{ request()->url() }}" id="filter" method="GET">
                <select name="category" id="flter_by_category" class="form-control non-select2" style="min-width: 500px">
                    <option value="*">{{ trans('blog::language.include_categories') }}</option>
                    @foreach(get_all_categories() as $category)
                        <option value="{{ $category->id }}" {{ $category->id == request()->get('category') ? 'selected' : '' }}>
                            {{ $category->language('name') }}
                        </option>
                    @endforeach
                </select>
            </form>
            <div class="clearfix"></div>
        @endslot

        @include('partial.datatable')
    @endcomponent

@stop

@push('footer')
<script>
    $('#flter_by_category').change(function (e) {
        $('#filter').trigger('submit');
    });

    var showImportPannel = function () {
        $('#import').toggleClass('hidden');
    };
    $(document).on('change', '[data-toggle="change-position"]', function (event) {
        $.ajax({
            url: CNV.baseUrl + '/iadmin/post/sort/' + $(this).data('id'),
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

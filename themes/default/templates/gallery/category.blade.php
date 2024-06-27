@extends('theme::layout')
@push('header')
    <script>
             CNV.categoryActive = '/gallery/collections?id=' + {{ $category->category->id }};
    </script>
@endpush
@section('content')
@foreach($gallery as $key => $item)
  @if($item->type == 'video')
  {{-- Load Banner --}}
      <div class="banner banner_customer">
              {!! strip_tags(widget('banner-video'),'<img>') !!}
      </div>
  {{-- End Load Banner --}}
  @break;
  @else
  {{-- Load Banner --}}
  <div class="banner banner_customer">
          {!! strip_tags(widget('banner-album'),'<img>') !!}
  </div>
  {{-- End Load Banner --}}
  @break;
  @endif
@endforeach


@include('theme::partial.heading')

    <div class="container gallerys">

        <div class="row">
          <div class="col-sm-12">
            <div class="row">
                @foreach($gallery as $key => $item)
                    @if($item->type == 'video')
                        @include('theme::gallery.item_video')
                    @else
                        @include('theme::gallery.item_album')
                        @if($loop->iteration % 3 == 0)
                          <div class="clearfix"></div>
                        @endif
                    @endif
                @endforeach
            </div>
          </div>
        </div>
    </div>
    @if($gallery->links() != '')
      <div class="pagination">
          {!! $gallery->links() !!}
      </div>
    @endif
@endsection

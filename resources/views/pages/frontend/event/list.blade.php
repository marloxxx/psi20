@foreach ($events as $event)
    <div class="col-md-6">
        <div class="tour_container">
            <div class="img_container">
                <a href="{{ route('events.show', $event->id) }}">
                    {{-- <div class="ribbon popular"></div> --}}
                    <img src="{{ asset($event->images->first()->image_path) }}" width="800" height="533"
                        class="img-fluid" alt="Image">

                </a>
            </div>
            <div class="tour_title">
                <i class="fa fa-calendar"></i> {{ $event->start_date->format('d M Y') }} -
                {{ $event->end_date->format('d M Y') }}
                <h3><strong>{{ $event->title }}</strong></h3>
                <small>{{ $event->address }}</small>
            </div>
        </div><!-- End box tour -->
    </div><!-- End col -->
@endforeach
{{ $events->links('components.pagination') }}

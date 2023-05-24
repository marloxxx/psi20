@foreach ($homestays as $homestay)
    <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-4 col-md-4 position-relative">
                @auth
                    <div
                        class="{{ auth()->user()->wishlists->contains($homestay->id)? 'wishlist-active': 'wishlist-inactive' }}">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"
                            onclick="toggleWishlist({{ $homestay->id }})">
                            {{ auth()->user()->wishlists->contains($homestay->id)? '-': '+' }}
                            <span class="tooltip-content-flip">
                                <span class="tooltip-back">
                                    {{ auth()->user()->wishlists->contains($homestay->id)? 'Remove from wishlist': 'Add to wishlist' }}
                                </span>
                            </span>
                        </a>
                    </div>
                @endauth
                <div class="img_list">
                    <a href="{{ route('homestays.show', $homestay->id) }}">
                        {{-- <div class="ribbon popular"></div> --}}
                        <img src="{{ asset($homestay->images->first()->image_path) }}" alt="image" />
                        <div class="short_info"></div>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="tour_list_desc">

                    <h3><strong>{{ $homestay->name }}</strong> </h3>
                    <p>{{ $homestay->address }}</p>
                    <ul class="add_info">
                        @foreach ($homestay->facilities as $facility)
                            <li>
                                <a href="javascript:void(0);" class="tooltip-1" data-bs-placement="top"
                                    title="{{ $facility->name }}">
                                    <i class="{{ $facility->icon }}"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-2">
                        <p>{!! Str::limit($homestay->description, 100) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="price_list">
                    <div>
                        <sup>Rp</sup>{{ number_format($homestay->price_per_night) }}
                        <small>*per malam</small>
                        <center class="mb-3">
                            <div class="rating">
                                @for ($i = 0; $i < $homestay->rating; $i++)
                                    <i class="icon-star voted"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - $homestay->rating; $i++)
                                    <i class="icon-star-empty"></i>
                                @endfor
                            </div>
                        </center>
                        <p><a href="{{ route('homestays.show', $homestay->id) }}" class="btn_1">Details</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End strip -->
@endforeach
{{ $homestays->links('components.pagination') }}

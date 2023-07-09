@extends('frontend.layouts.app')

@section('styles')

@endsection

@section('content')

    <section>
        <div class="container">
            <div class="row">

                <div class="col s12 m4 card">

                    <h2 class="sidebar-title">search property</h2>

                    <form class="sidebar-search" action="{{ route('search')}}" method="GET">

                        <div class="searchbar">
                            <div class="input-field col s12">
                                <input type="text" name="city" id="autocomplete-input-sidebar" class="autocomplete custominputbox" autocomplete="off" value="{{request()->get('city') ?? ''}}">
                                <label for="autocomplete-input-sidebar">Enter City or State</label>
                            </div>

                            <div class="input-field col s12">
                                <select name="type" class="browser-default">
                                    <option value="" disabled selected>Choose Type</option>
                                    <option value="apartment" {{ request()->get('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="house" {{ request()->get('type') == 'house' ? 'selected' : '' }}>House</option>
                                </select>
                            </div>

                            <div class="input-field col s12">
                                <select name="purpose" class="browser-default">
                                    <option value="" disabled selected>Choose Purpose</option>
                                    <option value="rent" {{ request()->get('purpose') == 'rent' ? 'selected' : '' }}>Rent</option>
                                    <option value="sale" {{ request()->get('purpose') == 'sale' ? 'selected' : '' }}>Sale</option>
                                </select>
                            </div>

                            <div class="input-field col s12">
                                <select name="bedroom" class="browser-default">
                                    <option value="" disabled selected>Choose Bedroom</option>
                                    @foreach($bedroomdistinct as $bedroom)
                                        <option value="{{$bedroom->bedroom}}" {{request()->get('bedroom') == $bedroom->bedroom ? 'selected' : ''}}>{{$bedroom->bedroom}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-field col s12">
                                <select name="bathroom" class="browser-default">
                                    <option value="" disabled selected>Choose Bathroom</option>
                                    @foreach($bathroomdistinct as $bathroom)
                                        <option value="{{$bathroom->bathroom}}" {{request()->get('bathroom') == $bathroom->bathroom ? 'selected' : ''}}>{{$bathroom->bathroom}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-field col s12">
                                <input type="number" name="minprice" id="minprice" class="custominputbox" value="{{request()->get('minprice') ?? ''}}">
                                <label for="minprice">Min Price</label>
                            </div>

                            <div class="input-field col s12">
                                <input type="number" name="maxprice" id="maxprice" class="custominputbox" value="{{request()->get('maxprice') ?? ''}}">
                                <label for="maxprice">Max Price</label>
                            </div>

                            <div class="input-field col s12">
                                <input type="number" name="minarea" id="minarea" class="custominputbox" value="{{request()->get('minarea') ?? ''}}">
                                <label for="minarea">Floor Min Area</label>
                            </div>

                            <div class="input-field col s12">
                                <input type="number" name="maxarea" id="maxarea" class="custominputbox" value="{{request()->get('maxarea') ?? ''}}">
                                <label for="maxarea">Floor Max Area</label>
                            </div>

                            <div class="input-field col s12">
                                <div class="switch">
                                    <label>
                                        <input type="checkbox" name="featured" {{request()->get('featured') == 'on' ? 'checked' : ''}}>
                                        <span class="lever"></span>
                                        Featured
                                    </label>
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <button class="btn btnsearch indigo" type="submit">
                                    <i class="material-icons left">search</i>
                                    <span>SEARCH</span>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>

                <div class="col s12 m8">

                    @forelse($properties as $property)
                        <div class="card horizontal">
                            <div>
                                <div class="card-content property-content">
                                    @if(Storage::disk('public')->exists('property/'.$property->image) && $property->image)
                                        <div class="card-image blog-content-image">
                                            <img src="{{Storage::url('property/'.$property->image)}}" alt="{{$property->title}}">
                                        </div>
                                    @endif
                                    <span class="card-title search-title" title="{{$property->title}}">
                                        <a href="{{ route('property.show',$property->slug) }}">{{ $property->title }}</a>
                                    </span>

                                    <div class="address">
                                        <i class="small material-icons left">location_city</i>
                                        <span>{{ ucfirst($property->city) }}</span>
                                    </div>
                                    <div class="address">
                                        <i class="small material-icons left">place</i>
                                        <span>{{ ucfirst($property->address) }}</span>
                                    </div>

                                    <h5>
                                        &dollar;{{ $property->price }}
                                        <small class="right">{{ $property->type }} for {{ $property->purpose }}</small>
                                    </h5>

                                </div>
                                <div class="card-action property-action clearfix">
                                    <span class="btn-flat">
                                        <i class="material-icons">check_box</i>
                                        Bedroom: <strong>{{ $property->bedroom}}</strong>
                                    </span>
                                    <span class="btn-flat">
                                        <i class="material-icons">check_box</i>
                                        Bathroom: <strong>{{ $property->bathroom}}</strong>
                                    </span>
                                    <span class="btn-flat">
                                        <i class="material-icons">check_box</i>
                                        Area: <strong>{{ $property->area}}</strong> Sq Ft
                                    </span>
                                    <span class="btn-flat">
                                        <i class="material-icons">comment</i>
                                        {{ $property->comments_count}}
                                    </span>

                                    @if($property->featured == 1)
                                        <span class="right featured-stars">
                                            <i class="material-icons">stars</i>
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center my-5">
                            No matching result found!
                        </div>
                    @endforelse


                    <div class="m-t-30 m-b-60 center">
                        {{
                            $properties->appends([
                                'city'      => Request::get('city'),
                                'type'      => Request::get('type'),
                                'purpose'   => Request::get('purpose'),
                                'bedroom'   => Request::get('bedroom'),
                                'bathroom'  => Request::get('bathroom'),
                                'minprice'  => Request::get('minprice'),
                                'maxprice'  => Request::get('maxprice'),
                                'minarea'   => Request::get('minarea'),
                                'maxarea'   => Request::get('maxarea'),
                                'featured'  => Request::get('featured')
                            ])->links()
                        }}
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection

@section('scripts')

@endsection

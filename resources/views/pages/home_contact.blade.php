@extends('layout')
@section('content')
    @php
        $user = Auth::guard('customer')->user();
    @endphp
    
    <div class="contact-wrapper">
        {{-- Title --}}
        <h3 class="title-checkout"><i class="fas fa-paper-plane"></i> Contact</h3>
        <hr>
        <h4 class="title-checkout"> We'd <i class="fas fa-heart"></i> to help!</h4>
        
        <div class="container contact-row-wrapper">
            <div class="row">

                {{-- Email form --}}
                <div class="col-md-6">
                    <form action="{{route('contact.send.email')}}" class="contact-form" method="POST">
                        @csrf
                        @if (Auth::guard('customer')->check())
                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{$user->user_name}}" disabled>
                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{$user->email}}" disabled>
                        @else
                            <input type="text" class="form-control" placeholder="Name" name="name">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                        @endif

                        <input type="text" class="form-control" placeholder="Subject" name="subject">
                        <textarea rows="8" placeholder="Please let us know your opinion..." name="info"></textarea>
                        <button class="btn" type="submit">Send</button>
                    </form>
                </div>
                <div class="col-md-1"></div>
                {{-- Company info --}}
                <div class="col-md-5">
                    <table class="table table-borderless align-middle contact-info-table">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-map-marker-alt"></i></td>
                                <td>18111 Nordhoff St, Northridge, CA 91330</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-mobile-alt"></i></td>
                                <td>(818) 123-456</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-envelope-open-text"></i></td>
                                <td>burgerz.elaravel@gmail.com</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <div class="contact-social-icon">
                        <a href="#"><i class="fab fa-facebook-square fa-lg"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#"><i class="fab fa-github fa-lg"></i></a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Google map --}}
        <div class="map-wrapper">
            <div id="googleMap" style="width:100%;height:400px;"></div>
        </div>

    </div>

    <script>
        function myMap() {
        var mapProp= {
          center:new google.maps.LatLng(34.2410, -118.5277),
          zoom:10,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }
        </script>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCF16UOehjlVeTQ6Q9wwc92FuTKUVIzZk4&callback=myMap"></script>
@endsection
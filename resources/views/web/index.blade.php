@extends('web.master')
@section('body')
<style>
.content-inner-1 {
    padding-top: 100px !important;
}
</style>
<style>
.card-container_new {
    position: relative;
    overflow: hidden;
    height: 300px;
    border-radius: 10px;
}

.card-container_new img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s ease;
}

.card-overlay {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    padding: 10px 15px;
    font-size: 1.2rem;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.5s ease;
}

.card-container_new:hover img {
    filter: blur(5px) brightness(0.7);
}

.card-container_new:hover .card-overlay {
    bottom: 50%;
    left: 50%;
    transform: translate(-50%, 50%);
    background: rgba(0, 0, 0, 0.7);
}
</style>
<div class="page-content bg-white">
    @php
    $photos = App\Models\Gallery::orderBy("sort", "desc")->get();
    @endphp

    <div class="row">
        <img src="https://riceshop.cryptodroplists.com/images/photos/1742887048-Catagory%20Soonrice.jpg">
       
        <!--<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">-->
        <!--    <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
        <!--    <span class="visually-hidden">Previous</span>-->
        <!--</button>-->
        <!--<button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">-->
        <!--    <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
        <!--    <span class="visually-hidden">Next</span>-->
        <!--</button>-->
    </div>

    <style>
    .carousel-item {
        height: 600px;
    }

    .carousel-image {
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 992px) {
        .carousel-item {
            height: 500px;
        }
    }

    @media (max-width: 768px) {
        .carousel-item {
            height: 350px;
        }
    }

    @media (max-width: 576px) {
        .carousel-item {
            height: 250px;
        }
    }
    </style>


    <!-- Intro Start -->
    <div class="container py-5">
        <div class="text-center">
            <h1 class="fw-bold text-primary">{{ env('APP_NAME') }}</h1>
            <p class="mt-3 text-muted px-md-5">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis eligendi quo, natus unde quaerat
                itaque totam quas minima, adipisci distinctio minus ipsam! Nulla laboriosam exercitationem amet debitis
                ullam doloribus blanditiis.
            </p>
            <br>
             <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($photos as $key => $photo)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset($photo->image) }}" style="border-radius:0px !important;"
                            class="d-block w-100 carousel-image" alt="Image {{ $key + 1 }}">
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <center>
                <br>
                <hr style="width:70%;" class="mt-4">
            </center>
        </div>
    </div>
    <!-- Intro End -->



    <div class="container mt-5">
        <div class="row g-4">
            <h3>Main Category </h3>
            @php
            $categories = App\Models\ProductCategory::orderBy('order_list','ASC')->get();
            @endphp
            @foreach($categories as $category)
            <div class="col-md-6">
                <div class="card-container_new">
                    <a href="/products/category/{{$category->id}}">
                        <img src="{{ asset('images/product_categories/' . $category->icon) }}" alt="Image 1">
                        <div class="card-overlay">{{ $category->name }}</div>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>


    <center>
        <br>
        <hr style="width:70%;" class="mt-4">
    </center>

    <section class="content-inner-1">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="wow fadeInUp" data-wow-delay="0.3s">
                        <h3 class="title">OUr Latest products</h3>
                        <div class="site-filters clearfix d-flex align-items-center">

                            <a href="/products"
                                class="product-link text-secondary font-14 d-flex align-items-center gap-1 text-nowrap">See
                                all products
                                <i class="icon feather icon-chevron-right font-18"></i>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix">
                        <ul id="masonry" class="row g-xl-4 g-3">
                            @foreach($Latest_products as $product)
                            <li class="card-container col-6 col-xl-3 col-lg-3 col-md-4 col-sm-6 Begs mt-5">
                                <div class="shop-card">
                                    <a href="/products/{{$product->id}}/detail">
                                        <div class="dz-media">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                style="max-height:300px !important" loading="lazy">

                                        </div>
                                        <div class="dz-content">
                                            <h5 class="title">{{ $product->name }}</h5>

                                            <h6 class="price" style="color:black !important;">
                                                @if($product->product_type == 1)
                                                @if($product->discount_type == 0)
                                                {{$product->price}} ¥
                                                @elseif($product->discount_type == 1)
                                                @php
                                                $discount_price = $product->price - $product->discount_amount;
                                                @endphp
                                                <del>{{$product->price}} </del>
                                                {{$discount_price}} ¥
                                                @elseif($product->discount_type == 2)
                                                @php
                                                $discount_price = $product->price - ( $product->price * (
                                                $product->discount_amount / 100 ));
                                                @endphp
                                                <del>{{$product->price}} </del>
                                                {{$discount_price}} ¥
                                                @endif
                                                @elseif($product->product_type == 2)
                                                @php
                                                $minPrice = $product->variants->min('price');
                                                $maxPrice = $product->variants->max('price');
                                                echo $minPrice . " ~ " . $maxPrice . " ¥" ;
                                                @endphp
                                                @endif

                                            </h6>
                                        </div>
                                        @if($product->discount_type != 0)
                                        <div class="product-tag">
                                            <span class="badge badge-secondary">Sale |
                                                @if($product->discount_type == 1)
                                                {{$product->discount_amount}} ¥ OFF
                                                @elseif($product->discount_type == 2)
                                                {{$product->discount_amount}} % OFF
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                        @if($product->pre_order == 1)
                                        <div class="product-tag">
                                            <span class="badge badge-info">
                                                Pre Order
                                            </span>
                                        </div>
                                        @endif
                                    </a>
                                </div>

                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Our Feature -->
    <section class="overlay-black-light our-features"
        style="background-image: url('images/image1.jpg'); background-repeat:no-repeat; background-size:cover;">
        <div class="container">
            <div class="features-content wow ">
                <h2>Enjoy the best quality and features made by {{env('APP_NAME')}} .</h2>
                <a href="/proudcts" class="btn btn-light">Shop Now</a>
            </div>
        </div>
    </section>
    <!-- Our Feature End -->

    <!-- Get In Touch -->
    <section class="get-in-touch wow " style="background-color:black !important;">
        <div class="m-r100 m-md-r0 m-sm-r0">
            <h3 class="dz-title mb-lg-0 mb-3">Questions ?
                <span>Our experts will help find the grar that’s right for you</span>
            </h3>
        </div>
        <a href="/faq" class="btn btn-light">Get In Touch</a>
    </section>
    <!-- Get In Touch End -->

</div>

@endsection
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <base href="/">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title","Ogani | Shop")</title>
    @yield("before_css")
    @include("layouts.head")
    @yield("after_css")
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

@include("layouts.header")

@include("layouts.nav")

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Organi Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    @yield("main")
</section>
<!-- Product Section End -->

@include("layouts.footer")

@yield("before_js")
@include("layouts.scripts")
@yield("after_js")
</body>
</html>

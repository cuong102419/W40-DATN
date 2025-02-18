@extends('client.layout.master')

@section('title')
    Bài viết
@endsection

@section('content')
    <!--== Start Blog Area Wrapper ==-->
    <section class="blog-details-area">
        <div class="container pb-lg-85">
            <div class="row justify-content-center">
                <div class="col-lg-11" data-aos="fade-up">
                    <div class="blog-details-content-wrap">
                        <div class="blog-details-item">
                            <div class="blog-details-thumb">
                                <img src="{{ asset('client/img/blog/details1.webp')}}" width="750" height="459" alt="Image-HasTech">
                            </div>
                            <div class="blog-meta-post">
                                <ul>
                                    <li class="post-date"><i class="fa fa-calendar"></i><a href="blog.html">22,Jun 2022</a>
                                    </li>
                                    <li class="author-info"><i class="fa fa-user"></i><a href="blog.html">Hector Lovett</a>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="main-title">Lorem ipsum dolor sit amet conse adipisi elit sed do eiusmod tempor.</h3>
                            <div class="details-wrapper details-wrapper-style1" data-margin-bottom="38">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore eto dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamcol laboris nisi ut aliquipp ex ea commodo consequat. Duis aute irure
                                    dolor in reprehenderit inloifk voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur. Excepteur sint occaec cupidatat non proident, sunt in culpa qui officia
                                    deserunt mollit anim id est laborum.</p>
                                <blockquote>
                                    <div class="inner-content">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. has
                                            been the industry's standard dummy text</p>
                                        <span class="user-name">Rachel Leonard</span>
                                        <img class="inner-shape" src="{{ asset('client/img/icons/quote2.webp')}}" width="82" height="59"
                                            alt="Image-HasTech">
                                    </div>
                                </blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore eto dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamcol laboris nisi ut aliquipp ex ea commodo consequat. Duis aute irure
                                    dolor in reprehenderit inloifk voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.</p>
                            </div>
                            <div class="details-wrapper details-wrapper-style2">
                                <p><img class="p-image-right" src="{{ asset('client/img/blog/details2.webp')}}" width="370" height="400"
                                        alt="Image-HasTech"><span>Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                        since the 1500s, whenan unknown printer took a galley of type and scrambled it to
                                        make a type tun tuni is specimen book. It has survived not only five centuries, but
                                        also the leap into tuna electronic typesetting, remaining essentially unchanged. It
                                        was popularised in the 1960s with the release of Letraset sheets containing</span>
                                </p>
                                <p> leu fugiat nulla pariatur. Excepteur sintocca cupidatat non proident, sunt in culpa qui
                                    off deserunt mollit anim id est laborum. Sed utl perspiciatis unde omnis iste natus
                                    error sit voluptatem accusantium</p>
                                <p class="mb-25"> leu fugiat nulla pariatur. Excepteur sintocca cupidatat non proident, sunt
                                    in culpa qui off deserunt mollit anim id est laborum. Sed utl perspiciatis unde omnis
                                    iste natus error sit voluptatem accusantium</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore eto dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamcol laboris nisi ut aliquipp ex ea commodo consequat. Duis aute irure
                                    dolor in reprehenderit inloifk voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.</p>
                            </div>
                            <div class="blog-details-footer">
                                <div class="tage-list">
                                    <span>Tages:</span>
                                    <a href="blog.html">Mobile</a>,
                                    <a href="blog.html">Laptop</a>,
                                    <a href="blog.html">Smart</a>,
                                    <a href="blog.html">TV</a>
                                </div>
                                <div class="social-icons">
                                    <span>Share:</span>
                                    <a href="#/"><i class="fa fa-facebook"></i></a>
                                    <a href="#/"><i class="fa fa-dribbble"></i></a>
                                    <a href="#/"><i class="fa fa-pinterest-p"></i></a>
                                    <a href="#/"><i class="fa fa-twitter"></i></a>
                                </div>
                            </div>
                            <div class="article-next-previous">
                                <div class="arrow-item previous">
                                    <div class="arrow-thumb">
                                        <a href="blog-details.html"><img src="{{ asset('client/img/blog/s4.webp')}}" width="98"
                                                height="101" alt=""></a>
                                        <a class="overlay" href="blog-details.html"><i class="fa fa-angle-left"></i></a>
                                    </div>
                                    <div class="arrow-content">
                                        <span class="date"><a href="blog.html"><i class="fa fa-calendar"></i>26 March,
                                                2022</a></span>
                                        <h6 class="title"><a href="blog-details.html">Lorem ipsum dolorl amet conse adip</a>
                                        </h6>
                                    </div>
                                </div>
                                <div class="arrow-item next">
                                    <div class="arrow-thumb">
                                        <a href="blog-details.html"><img src="{{ asset('client/img/blog/s1.webp')}}" width="98"
                                                height="101" alt=""></a>
                                        <a class="overlay" href="blog-details.html"><i class="fa fa-angle-right"></i></a>
                                    </div>
                                    <div class="arrow-content">
                                        <span class="date"><a href="blog.html">25 March, 2022<i
                                                    class="fa fa-calendar"></i></a></span>
                                        <h6 class="title"><a href="blog-details.html">Lorem ipsum dolorl amet conse adip</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Blog Area Wrapper ==-->
@endsection
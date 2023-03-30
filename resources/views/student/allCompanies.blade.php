@extends('student.master')

@section('title' ,  __('admin.Avilable Companies'))


@section('content')

<section class="bg-light" id="reviews">
    <div class="container">
        <h1 class="text-white">{{ __('admin.Avilable Companies') }}</h1>
    </div>
</section>

<section>
    <div class="container">
        <div class="search_wrapper mb-5">

            <div class="input-box">
                <input type="text" placeholder="{{ __('admin.Search by Company Name...') }}"  id="search_input" autocomplete="off"/>
                <span><i class="fas fa-times hide" id="clear_input"></i></span>
                <span class="search">
                  <i class="fas fa-search search-icon"></i>
                </span>
                <i class="fas fa-times close-icon"></i>
                <ul id="companies_dropdown">

                </ul>
            </div>
        </div>


        <div class="row" id="categories_wrapper">
            @foreach ($companies as $company )
                @foreach ( $company->categories as $category )
                        <div class="col-md-4">
                            <article class="blog-post">
                                <img src="{{ asset($company->image) }}" alt="">

                                <span>{{ $category->name  }}</span>


                                <div class="content">
                                    <h5>{{ $company->name }}</h5>
                                    <p class="mb-4">{{ Str::words(strip_tags(html_entity_decode($company->description)), 6, '...') }}</p>

                                    <a href="{{ route('student.company' ,[$company->slug , $category->name]) }}" class="btn-brand">{{ __('admin.Learn More') }}</a>
                                </div>
                            </article>
                        </div>
                @endforeach
            @endforeach
        </div>
        <div class="text-center" id="load-more"><button class="btn btn-brand" id="load_more_btn" data-page="1">{{ __('admin.Load More') }}</button></div>
    </div>
</section>

@stop

@section('scripts')
{{-- Load more --}}
<script>
    $(document).ready(function() {
        var wrapper = $("#categories_wrapper");
        var url = 'load/more/categories';


        $(document).on("click", '#load_more_btn', function() {
            let page = $(this).data("page");
            $.ajax({
                type: "get",
                url: url,
                data: {page: page},
                beforeSend: function() {
                    $('#load-more').html('<i class="fa fa-spin fa-spinner"></i> {{ __("admin.Loading...") }}');
                },
                success:function(response) {
                    if(response.length > 0) {
                        wrapper.append(response);
                        page++;
                        btn = `<button class="btn btn-brand" id="load_more_btn" data-page="${page}">{{ __('admin.Load More') }}</button>`;
                        $("#load-more").empty();
                        $("#load-more").append(btn);
                    } else {
                        $("#load-more").empty();
                        $("#load-more").html('<span style="color = #1a2e44">{{ __("admin.There is no more to load.") }}</span>');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        })
    })
</script>

{{-- Search --}}
<script>
    $(document).ready(function() {
        $("#companies_dropdown").hide();
        var input = $("#search_input");

        input.on("keyup", function() {
            let search = $(this).val();

            if(search.length > 0) {
                $("#clear_input").removeClass('hide');
                $("#clear_input").on("click", function() {
                    input.val("");
                    $("#clear_input").addClass('hide');
                })
            } else {
                $("#clear_input").addClass('hide');
            }

            if(search.length > 1 || search.length == 0) {
                $.ajax({
                    type: "get",
                    url: 'get/companies/names',
                    data: {search: search},
                    success:function(response) {
                        if(response.content) {
                            $("#companies_dropdown").hide()
                            $("#categories_wrapper").empty();
                            $("#categories_wrapper").html(response.content);
                            $("#load_more_btn").show();
                        }else if(response.message) {
                            $("#companies_dropdown").show()
                            $("#companies_dropdown").empty();
                            let msg = `<p style="padding: 10px;">{{ __('admin.There is no result for') }}<b><i>${search}</i></b></p>`;
                            $("#companies_dropdown").append(msg);
                        }
                        else {
                            $("#companies_dropdown").empty();
                            $.each(response.companies, function(index, value) {
                                let row = `<li><a href="#" id="dropdown_item" data-name="${value}" data-id="${index}">${value}</a></li>`
                                $("#companies_dropdown").show();
                                $("#companies_dropdown").append(row);
                            })

                        }
                    }, error:function(response) {
                        console.log(response.errors);
                    }
                })
            }
        })

    })
    $(document).on("click", '#dropdown_item', function(event) {
        event.preventDefault();
        $("#companies_dropdown").hide()
        let company_id = $(this).data("id");
        let name = $(this).data("name").toLowerCase();
        $("#search_input").val(name);
        $.ajax({
            type: "get",
            url: 'search/companies',
            data: {company_id: company_id},
            beforeSend: function() {
                $('#categories_wrapper').html('<div class="d-flex justify-content-center align-items-center" style="font-size: 24px; height: inherit; gap: 10px; color: #1a2e44;"><i class="fa fa-spin fa-spinner"></i> {{ __("admin.Loading...") }}</div>');
            },
            success:function(response) {
                if(response.length > 0) {
                    $("#categories_wrapper").empty();
                    $("#load_more_btn").hide();
                    $("#categories_wrapper").html(response);
                } else {
                    var empty = `<span class="text-center mt-5">{{ __('admin.There is no result for') }} <i><b>${search}</b></i></span>`;
                    $("#categories_wrapper").empty();
                    $("#categories_wrapper").html(empty);
                }
            }, error:function(response) {
                console.log(response.errors);
            }
        })
    })
    $(document).on("click", function() {
        $("#companies_dropdown").hide();
    })
</script>
{{-- search bar --}}
<script>
    // ---- ---- Const ---- ---- //
    let inputBox = document.querySelector('.input-box'),
    searchIcon = document.querySelector('.search'),
    closeIcon = document.querySelector('.close-icon');
    inputSearch = document.querySelector('#search_input');

    // ---- ---- Open Input ---- ---- //
    searchIcon.addEventListener('click', () => {
        inputBox.classList.add('open');
        $("#search_input").focus();
        if(inputSearch.value != 0) {
            setTimeout(() => {
                $("#clear_input").removeClass('hide');
            }, 350);
        }
    });
    // ---- ---- Close Input ---- ---- //
    closeIcon.addEventListener('click', () => {
        inputBox.classList.remove('open');
        $("#clear_input").addClass('hide');
    });


</script>

@endsection

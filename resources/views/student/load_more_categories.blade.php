@foreach ($companies as $company )
      @foreach ( $company->categories as $category )
            <div class="col-md-4">
                  <article class="blog-post">
                        <img src="{{ asset($company->image) }}" alt="">

                        <span>{{ $category->name  }}</span>


                        <div class="content">
                        <h5>{{ $company->name }}</h5>
                        <p class="mb-4">{{ Str::words(strip_tags(html_entity_decode($company->description)), 10, '...') }}</p>

                        <a href="{{ route('student.company' ,[$company->slug , $category->name]) }}" class="btn-brand">{{ __('admin.Learn More') }}</a>
                        </div>
                  </article>
            </div>
      @endforeach
@endforeach

<div class="col-lg-4 col-md-6 mb-4">
    <article>
        <div class="category p-3">
            @if ($row->subCategory == null)
                <span style="background-color: rgb(215, 215, 215);" class="color"></span>
                <span class="name">{{ mainTrans('blog.general') }}</span>
            @else
                <span style="background-color:{{ $row->subCategory->color }};" class="color"></span>
                <span class="name">{{ $row->subCategory->name }}</span>
            @endif
        </div>
        <!-- category -->
        <a href="{{ url($row->slug) }}">
            <img class="img-fluid lazy" data-src="{{ articleImg($row->image) }}" alt="صورة المقال"
                title="{{ $row->title }}" />
            <div class="content p-3">
                <h3 class="article-title text-center dir-ltr font-20 mb-2">{{ Str::limit($row->title, 75, '...') }}</h3>
                <span class="date font-14 d-block dir-ltr"> {{ date('Y ,F j ', strtotime($row->created_at)) }}</span>
            </div>
        </a><!-- Link -->
    </article>
</div>
<!--- End Col Article -->

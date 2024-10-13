@section('title',$tag->tag)
<x-layout>
    <div class="row">
        <div class="col-md-5 m-2">
            <a href="{{ $tag->url }}" data-lightbox="photos">
                <img style="width:450px;" class="img-fluid" src="{{ $tag->url }}">
            </a>
        </div>
        <div class="col-md-6">
            <ul class="m-2">
                <li>
                    <h3>{{ $tag->tag}}</h3><span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"> Ahadith found ({{ $tag->posts->count() }}) </h6>
            <div class="container row m-2">
                @php
                $posts=$tag->posts;
                @endphp

                @foreach($posts as $post)
                <x-post-card classes="col-md-3" :member="$post->post"/>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
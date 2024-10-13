@section('title',$content->title)
<x-layout>
    <div class="row">
        <div class="col-md-5 m-2">
            <a href="{{ $content->url }}" data-lightbox="photos">
                <img style="width:450px;" class="img-fluid" src="{{ $content->url }}">
            </a>
        </div>
        <div class="col-md-6">

            @if($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('adminstore',$content->id) }}">
                @csrf
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">{{ $content->title }}</h6>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $content->title }}" id="title" name="title">
                        <label for="title">Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="approved" name="approved" aria-label="Floating label select example">
                            <option selected>Approved</option>
                            <option value="1" {{ $content->approved==1 ? "selected" :"" }}>Yes</option>
                            <option value="0" {{ $content->approved==0 ? "selected" :"" }}>No</option>
                        </select>
                        <label for="posted">Approved</label>
                    </div>
                    <div class="form-floating mb-2">
                        <select class="form-select m-2" id="posted" name="posted" aria-label="Floating label select example">
                            <option selected>Posted</option>
                            <option value="1" {{ $content->posted==1 ? "selected" :"" }}>Yes</option>
                            <option value="0" {{ $content->posted==0 ? "selected" :"" }}>No</option>
                        </select>
                        <label for="posted">Posted</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="comment" style="height: 150px;">{{ $content->comment }}</textarea>
                        <label for="floatingTextarea">Comments</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Add Explaination here" name="explaination" style="height: 150px;">{{ $content->explaination }}</textarea>
                        <label for="floatingTextarea">Explaination</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" value="{{ $content->url }}" name="url">
                        <label for="url">Url</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" value="{{ $content->ios_url }}" name="ios_url">
                        <label for="ios_url">IOS Url</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" value="{{ $content->thumb_url }}" name="thumb_url">
                        <label for="thumb_url">Thumb Url</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control date" id="title" value="{{ $content->scheduled_at }}" name="scheduled_at">
                        <label for="scheduled_at">Scheduled At</label>
                    </div>
                    <div class="form-floating mb-3">
                        @php
                        $tagsArr=$content->getPostTagIds();
                        @endphp
                        <select style="display:none;" class="multiselect" name="tags[]" multiple>
                            @foreach($tags as $k=>$v)
                            <option value="{{ $k }}" {{ in_array($k,$tagsArr) ? "selected" : " " }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
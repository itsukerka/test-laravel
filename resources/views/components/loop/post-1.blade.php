<?php
    use App\Models\User;
    use Carbon\Carbon;
    use App\Models\Post\Post;

    /** @var DateTime $created_at */
    /** @var User $author_id */
    $date = Carbon::parse($created_at);
    $updated = Carbon::parse($updated_at);
?>
<div class="ui-post--card bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
    <div class="wrapper">
        <div class="header px-6 pt-4">
            @if(User::find($author_id))
                <?php $User = User::findOrFail($author_id); ?>
            <div class="item author">
                <a href="{{url('profile/'.$author_id.'/')}}">{{ $User->name }}</a>
            </div>
                @endif

            <div class="item date">
                {{$date->diffForHumans()}}
            </div>
                @if($status == 'draft')
                    <div class="item status">
                        <span class="ui-post-status">
                            <span class="label">Draft</span>
                        </span>
                    </div>
                @endif
        </div>
        <a class="title px-6" href="{{strtolower(url('/'.$post_id.'-'.$slug.'/'))}}">{{$title}}</a>
        <div class="excerpt px-6 pb-3">
            <p class="mt-3 mb-0">{{ $excerpt }}</p>
        </div>

        <div class="footer px-6 pb-3">
            <a class="item" href="{{strtolower(url('/'.$post_id.'-'.$slug.'/'))}}#comments">
                <span class="icon">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </span>
                <span class="label">No Comments</span>
            </a>
        </div>
    </div>
</div>


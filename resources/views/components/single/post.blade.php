<?php
use App\Models\Post\Post;use App\Models\User\User;use Carbon\Carbon;

/** @var Post $post */

$date = Carbon::parse($post->created_at);
if($post->canEdit()){

}
?>

<main class="ui-main-layout">
    <div class="sidebar-left">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
    <div class="main-content">
        <div class="ui-post--card bg-white overflow-hidden shadow-sm  mb-4">
            <div class="wrapper">
                <div class="header px-6 pt-4">
                    @if(User::find($post->author_id))
                        <?php $User = User::findOrFail($post->author_id); ?>
                        <div class="item author">
                            <a href="{{url('profile/'.$post->author_id.'/')}}">{{ $User->name }}</a>
                        </div>
                    @endif

                    <div class="item date">
                        {{$date->diffForHumans()}}
                    </div>
                    @if($post->status == 'draft')
                        <div class="item status">
                        <span class="ui-post-status">
                            <span class="label">Draft</span>
                        </span>
                        </div>
                    @endif
                        @if($post->canEdit())
                            <div class="item status">
                                <a href="{{url('editor/'.$post->post_id)}}" class="ui-post-status">
                                    <span class="label">Edit</span>
                                </a>
                            </div>
                        @endif
                </div>
                <div class="content px-6 pb-3">
                    {{ $post->renderContent() }}
                </div>

                <div class="footer px-6 pb-3">
                    <a class="item" href="{{strtolower(url('/'.$post->post_id.'-'.$post->slug.'/'))}}#comments">
                <span class="icon">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </span>
                        <span class="label">No Comments</span>
                    </a>
                </div>
            </div>
        </div>


    </div>
    <div class="sidebar-right">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
</main>

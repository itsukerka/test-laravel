<?php
use Illuminate\Support\Facades\Request;
use App\Models\Post\Post;

$data = [];
if(isset($user_id)){
    $data['user_id'] = $user_id;
} else {
    $data['user_id'] = Auth::user()->id;
}
$routeName = Request::route()->getName();
$args = ['post_author' => $data['user_id']];
if($routeName == 'dashboard/draft'){
    $args['status'] = 'draft';
}
$data['posts'] = Post::get($args);

?>
<main class="ui-main-layout">
    <div class="sidebar-left">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
    <div class="main-content">

        {{ view('components.profile.header', $data) }}
        {{ view('components.profile.posts', $data) }}
    </div>
    <div class="sidebar-right">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
</main>

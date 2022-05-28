<?php
use Illuminate\Support\Facades\Request;
use App\Models\Post\Post;
$data = [];
$data['posts'] = Post::get();
?>
<main class="ui-main-layout">
    <div class="sidebar-left">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
    <div class="main-content">
       <div class="py-12"> {{ view('components.profile.posts', $data) }} </div>
    </div>
    <div class="sidebar-right">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
</main>

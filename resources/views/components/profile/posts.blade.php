<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
@foreach ($posts as $post)
    {{ view('components.loop.post-1', $post) }}
@endforeach
</div>


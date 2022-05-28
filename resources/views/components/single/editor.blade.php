<script src="{{ asset('js/editor.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/editor.css') }}">
<main class="ui-main-layout">
    <div class="sidebar-left">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
    <div class="main-content">
        <div class="border-b lg:px-8 mx-auto pb-3 sm:px-6 bg-white overflow-hidden">
            <div class="max-w-5xl flex justify-end">
                <div class="ui-button ui-button--1 mt-4" id="_save_post">Save Draft</div>
                @if(Auth::user()->role == 'admin')
                    <div class="ui-button mt-4 ml-2" id="_publish_post">Publish</div>
                @endif
            </div>
        </div>
        <div class="ui-post--card bg-white overflow-hidden  mb-4">
            @csrf
            <div id="editorjs"></div>
        </div>
    </div>
    <div class="sidebar-right">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/nested-list@latest"></script>
<script>
    var _page = {
        blocks: <?php echo json_encode($editor, JSON_UNESCAPED_UNICODE) ?>
    };
</script>


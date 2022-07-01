<?php
use App\Models\User\User;
$get_path = Request::route()->getName();

?>
@if(User::find($user_id))
<?php $User = User::findOrFail($user_id); ?>
<div class="header--author py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="border-b border-gray-200">
                <div class="profile--avatar">
                    {{ $User->get_avatar() }}
                </div>
                <h1 class="font-semibold p-6 pb-1 text-xxl">
                    {{ $User->name }}
                </h1>
                <div class="p-6 pt-1">
                    <p>
                        {{ $User->get_meta('description') }}
                    </p>
                    @if(Auth::user()->id == $user_id OR Auth::user()->role == 'admin')
                        <p><a href="{{ url('profile/'.$user_id.'/edit') }}">Изменить описание</a></p>
                    @endif
                </div>
            </div>
            <div class="hidden ml-2 pl-3 pr-4 pt-2 sm:flex sm:items-center sm:ml-2">
                @if(request()->is('dashboard'))
                <x-nav-link href="{{url('profile/'.$user_id)}}" :active="request()->is('dashboard')" class="px-2 p-5">
                    {{ __('All Posts') }}

                </x-nav-link>
                @else
                    <x-nav-link href="{{url('profile/'.$user_id)}}" :active="request()->is('profile/'.$user_id)" class="px-2 p-5">
                        {{ __('All Posts') }}

                    </x-nav-link>
                @endif
                @if(Auth::user())
                    @if(Auth::user()->id == $user_id)
                        <x-nav-link :href="route('dashboard/draft')" :active="request()->routeIs('dashboard/draft')" class="px-2 p-5">
                            {{ __('Draft') }}
                        </x-nav-link>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @if(Auth::user())
        @if(Auth::user()->id == $user_id)
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b">
                    <a href="{{url('/editor')}}" class="ui-new_article--button">
                        <span class="label">{{ __('New article') }}</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>



@else
    {{ view('components.error.404') }}
@endif

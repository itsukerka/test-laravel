<?php
use Illuminate\Support\Facades\Request;
use App\Models\User\User;
$data['user_id'] = $user_id;
$User = User::findOrFail($user_id);
?>
<main class="ui-main-layout">
    <div class="sidebar-left">
        <div class="sidebar--header"></div>
        <div class="sidebar--container">

        </div>
        <div class="sidebar--footer"></div>
    </div>
    <div class="main-content">

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="p-6 bg-white border-b border-gray-200 text-xl font-semibold">
                       Settings
                    </h1>
                    <form class="ui-form p-6" id="profile_edit" action="{{url('/profile/'.$user_id)}}" method="update">
                        @csrf
                        <div class="ui_form__fieldsets grid">
                            <div class="ui_form__fieldset" data-error="Invalid Name">
                                <div class="field">
                                    <input class="{{ $User->notEmptyClass($User->name) }}" name="fullname" id="fullname" type="text" required="" value="{{ $User->name }}" data-mask="name">
                                    <label for="fullname">Full Name</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>

                            <div class="ui_form__fieldset">
                                <div class="textarea field">
                                    <textarea name="description" class="w-100 {{ $User->notEmptyClass($User->get_meta('description')) }}" id="address">{{ $User->get_meta('description') }}</textarea>
                                    <label for="description">Description</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>

                            <div class="ui_form__fieldset" data-error="Invalid Email">
                                <div class="field">
                                    <input class="{{ $User->notEmptyClass($User->email) }}" name="email" id="email" type="text" disabled value="{{ $User->email }}" data-mask="email">
                                    <label for="email">E-mail</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>

                            <div class="ui_form__fieldset" data-error="Invalid Date">
                                <div class="field">
                                    <input class="not-empty" name="birthday" id="birthday" type="date" value="{{ $User->get_meta('birthday')  }}" required="">
                                    <label for="birthday">Birthday</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>
                        </div>
                        <div class="ui_form__fieldsets grid">
                            <div class="ui_form__fieldset" data-error="Invalid Phone">
                                <div class="field">
                                    <input class="{{ $User->notEmptyClass($User->get_meta('phone')) }}" name="phone" id="phone" type="text" required="" value="{{ $User->get_meta('phone') }}" data-mask="phone">
                                    <label for="phone">Contact Phone</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>
                            <div class="ui_form__fieldset">
                                <div class="field">
                                    <input class="{{ $User->notEmptyClass($User->get_meta('company')) }}" name="company" id="company" type="text" value="{{ $User->get_meta('company') }}">
                                    <label for="company">Company</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>
                        </div>

                        <div class="ui_form__fieldsets ">
                            <div class="ui_form__fieldset" data-error="Invalid Phone">
                                <div class="textarea field">
                                    <textarea name="address" class="w-100 {{ $User->notEmptyClass($User->get_meta('address')) }}" id="address">{{ $User->get_meta('address') }}</textarea>
                                    <label for="address">Address</label>
                                </div>
                                <div class="status"><span></span></div>
                                <div class="information"></div>
                            </div>
                        </div>

                        <div class="form__send">
                            <button class="ui-button" type="submit">Save</button>
                        </div>
                    </form>
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

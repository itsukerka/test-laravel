<?php
use App\Models\User;

?>
@if(User::find($user_id))
    <?php $User = User::findOrFail($user_id); ?>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="p-6 bg-white border-b border-gray-200 text-xl font-semibold">
                    Редактирование профиля
                </h1>
                <form class="ui-form" action="POST">
                    @csrf
                    <div class="ui_form__fieldsets grid">
                        <div class="ui_form__fieldset" data-error="Invalid Last Name">
                            <div class="field">
                                <input class="" name="lastname" id="lastname" type="text" required="" value="{{ $User->name }}" data-mask="name">
                                <label for="lastname">Full Name</label>
                            </div>
                            <div class="status"><span></span></div>
                            <div class="information"></div>
                        </div>

                        <div class="ui_form__fieldset" data-error="Invalid Date">
                            <div class="field">
                                <input class="not-empty" name="birthday" id="birthday" type="date" value="" required="">
                                <label for="birthday">Birthday</label>
                            </div>
                            <div class="status"><span></span></div>
                            <div class="information"></div>
                        </div>
                    </div>
                    <div class="ui_form__fieldsets grid">
                        <div class="ui_form__fieldset" data-error="Invalid Phone">
                            <div class="field">
                                <input class="" name="phone" id="phone" type="text" required="" value="" data-mask="phone">
                                <label for="phone">Contact Phone</label>
                            </div>
                            <div class="status"><span></span></div>
                            <div class="information"></div>
                        </div>
                        <div class="ui_form__fieldset">
                            <div class="field">
                                <input class="" name="company" id="company" type="text" value="">
                                <label for="company">Company</label>
                            </div>
                            <div class="status"><span></span></div>
                            <div class="information"></div>
                        </div>
                    </div>

                    <div class="ui_form__fieldsets ">
                        <div class="ui_form__fieldset" data-error="Invalid Phone">
                            <div class="textarea field">
                                <textarea name="address" class="w-100 " id="address"></textarea>
                                <label for="address">Address</label>
                            </div>
                            <div class="status"><span></span></div>
                            <div class="information"></div>
                        </div>
                    </div>

                    <div class="form__send">
                        <button class="base-button" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@else
    {{ view('components.error.404') }}
@endif

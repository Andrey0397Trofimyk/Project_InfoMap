
    @extends('layouts.userLayouts.headerPage')
        @section('content')
        <!-- Map -->
        <div class="content col-12">
            <gmap-component
            :info-location='{{$locations->get()}}'
            @position='insertLocations($event)'
            ></gmap-component>
        </div>
        <!-- Sidebar -->
        <div class="sidebar col-6">
            <sidebar-component
            :data='locationInfo'
            :comments='comments'
            :images-url='images'
            ></sidebar-component>
        </div>
        <!-- Modal windows -->
        <div class="modal fade" id="initWindow" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body" >

                        <div class="card">
                            <div class="card-header row">
                                <div v-if='initialization == items[0]' class='col-11'>
                                    {{ __('Вхід') }}
                                </div>
                                <div v-else class='col-11'>
                                    {{ __('Реєстрація') }}
                                </div>
                                <button type="button" class="close col-1 float-right" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <form method="POST" v-if='initialization == items[0]' action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Адрес') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Вхід') }}
                                            </button>

            
                                        </div>
                                    </div>
                                </form>
                                <form method="POST" v-else action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="name1" class="col-md-4 col-form-label text-md-right">{{ __("Ім'я") }}</label>

                                        <div class="col-md-6">
                                            <input id="name1" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email1" class="col-md-4 col-form-label text-md-right">{{ __('Email Адрес') }}</label>

                                        <div class="col-md-6">
                                            <input id="email1" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password1" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                                        <div class="col-md-6">
                                            <input id="password1" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm1" class="col-md-4 col-form-label text-md-right">{{ __('Повторіть пароль') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm1" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Реєстрація') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
        @endsection

<div class="col-lg-12 col-md-12 col-sm-12">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('error') }}</span>
                        </div>
                    </div>
                @endif
                <form action="{{ route('admin.admin_zoom_acount_store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2><strong>Create</strong> New Meeting </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button" onclick="window.location.href=''" class="btn btn-danger btn-sm boxs-close"><i class="zmdi zmdi-close"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix mt-3">
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="account_name">Meeting Title
                                            <sup class='text-danger'>*</sup>
                                        </b>
                                        <input type="text" class="form-control" name="meeting_title" id="meeting_title" require value="{{ old('meeting_title') }}" />
                                        @error("meeting_title")
                                            <div class="text-danger">
                                                {{ $message }}                                        
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b>Meeting Type
                                            <sup class='text-danger'>*</sup>
                                        </b>
                                        <select name="meeting_type" id="meeting_type" class='form-control' required>
                                            <option value="active" selected>Scheduled</option>
                                            <option value="instant" @if(old('status') == "instant") selected @endif>Instant</option>
                                            <option value="reoccuring" @if(old('reoccuring') == "suspend") selected @endif>Re-Occuring</option>
                                        </select>
                                        @error("meeting_type")
                                            <div class="text-danger">
                                                {{ $message }}                                        
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix mt-3">
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="account_username">
                                            Enable Meeting Lock
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </b>
                                        <div class="radio">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input checked type="radio" name="meeting_lock" id="meeting_lock_yes" value="yes">
                                                    <label for="meeting_lock_yes" class='text-success'>
                                                        Yes, Lock Meeting
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="meeting_lock" id="meeting_lock_no" value="yes">
                                                    <label for="meeting_lock_no" class='text-danger'>
                                                        No, Don't Lock Meeting
                                                    </label>
                                                </div>
                                            </div>
                                           

                                            
                                        </div>

                                        @error("username")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20" id="meeting_lock_settings">
                                    <div class="form-group">
                                        <b for="category">
                                            Lock After
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                            <small>Interval of Time in Minute</small>
                                        </b>
                                        <input type="int" class='form-control' name='lock_meeting_internval_time' />
                                        @error("category")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix mt-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b for="api_token">
                                            Scheduled Time
                                            <sup class="text-danger">*</sup>
                                        </b>
                                        <textarea name="api_token" placeholder="paste your token here" id="api_token" cols="30" rows="6" class='form-control'>{{old('api_token')}}</textarea>
                                        @error("api_token ")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer clearfix mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class='btn btn-primary btn-block'>Create Zoom Account</button>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </form>
            </div>
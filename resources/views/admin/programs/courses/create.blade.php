@extends("layouts.portal.app")

@section("page_title")
    Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>


@endsection


@section("content")
<!-- Main Content -->
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>{{ $program->program_name }} - Course Syllabus / Chapter</h2>   
                    <small>
                        [<a href=''>Create New Course</a>]
                    </small>                 
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>DS</strong> - Design Team <small>Ranking 2th</small></h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
									<li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Info about Design Team <span class="badge badge-success float-right">New</span></h6>                                
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                        <ul class="list-unstyled team-info m-t-20">
                            <li class="m-r-15"><small class="text-muted">Team</small></li>
                            <li><img src="assets/images/xs/avatar1.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar2.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar3.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar4.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar5.jpg" title="Avatar" alt="Avatar"></li>
                        </ul>
                        <div class="progress-container l-black m-b-20">
                            <span class="progress-badge">Prograss</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;">
                                    <span class="progress-value">68%</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <small>PROJECTS: 12</small>
                                <h6>BUDGET: 4,870 USD</h6>
                            </div>
                            <div class="col-5">
                                <div class="sparkline text-right m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#7460ee">2,5,8,3,5,7,1,6</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>MT</strong> - Marketing Team <small>Ranking 4th</small></h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Info about Marketing Team</h6>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                        <ul class="list-unstyled team-info m-t-20">
                            <li class="m-r-15"><small class="text-muted">Team</small></li>
                            <li><img src="assets/images/xs/avatar10.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar9.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar8.jpg" title="Avatar" alt="Avatar"></li>
                        </ul>
                        <div class="progress-container l-black m-b-20">
                            <span class="progress-badge">Prograss</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;">
                                    <span class="progress-value">78%</span>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-7">
                                <small>PROJECTS: 08</small>
                                <h6>BUDGET: 2,170 USD</h6>
                            </div>
                            <div class="col-5">
                                <div class="sparkline text-right m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#f96332">6,2,3,4,8,7,6,2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>DT</strong> - Developers Team <small>Ranking 5th</small></h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Info about Developers Team</h6>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                        <ul class="list-unstyled team-info m-t-20">
                            <li class="m-r-15"><small class="text-muted">Team</small></li>
                            <li><img src="assets/images/xs/avatar1.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar2.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar3.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar4.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar5.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar6.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar7.jpg" title="Avatar" alt="Avatar"></li>
                        </ul>
                        <div class="progress-container l-black m-b-20">
                            <span class="progress-badge">Prograss</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100" style="width: 48%;">
                                    <span class="progress-value">48%</span>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-7">
                                <small>PROJECTS: 23</small>
                                <h6>BUDGET: 8,000 USD</h6>
                            </div>
                            <div class="col-5">
                                <div class="sparkline text-right m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#2CA8FF">8,2,3,4,6,5,2,7</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>GT</strong> - Graphic Team <small>Ranking 2th</small></h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Info about Graphic Team</h6>                                
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                        <ul class="list-unstyled team-info m-t-20">
                            <li class="m-r-15"><small class="text-muted">Team</small></li>
                            <li><img src="assets/images/xs/avatar4.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar5.jpg" title="Avatar" alt="Avatar"></li>
                        </ul>
                        <div class="progress-container l-black m-b-20">
                            <span class="progress-badge">Prograss</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100" style="width: 18%;">
                                    <span class="progress-value">18%</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <small>PROJECTS: 2</small>
                                <h6>BUDGET: 3,370 USD</h6>
                            </div>
                            <div class="col-5">
                                <div class="sparkline text-right m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#ea4c89">2,5,8,3,5,7,1,6</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>ST</strong> - Sales Team <small>Ranking 7th</small></h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Info about Sales Team</h6>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>
                        <ul class="list-unstyled team-info m-t-20">
                            <li class="m-r-15"><small class="text-muted">Team</small></li>
                            <li><img src="assets/images/xs/avatar5.jpg" title="Avatar" alt="Avatar"></li>                            
                            <li><img src="assets/images/xs/avatar1.jpg" title="Avatar" alt="Avatar"></li>
                        </ul>
                        <div class="progress-container l-black m-b-20">
                            <span class="progress-badge">Prograss</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100" style="width: 58%;">
                                    <span class="progress-value">58 %</span>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-7">
                                <small>PROJECTS: 12</small>
                                <h6>BUDGET: 5,100 USD</h6>
                            </div>
                            <div class="col-5">
                                <div class="sparkline text-right m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#4183c4">6,2,3,4,8,7,6,2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>BD</strong> - Business Development <small>Ranking 8th</small></h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <h6 class="m-b-15">Info about Business Development Team</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.</p>
                        <ul class="list-unstyled team-info m-t-20">
                            <li class="m-r-15"><small class="text-muted">Team</small></li>                            
                            <li><img src="assets/images/xs/avatar2.jpg" title="Avatar" alt="Avatar"></li>
                            <li><img src="assets/images/xs/avatar3.jpg" title="Avatar" alt="Avatar"></li>                            
                            <li><img src="assets/images/xs/avatar5.jpg" title="Avatar" alt="Avatar"></li>                            
                            <li><img src="assets/images/xs/avatar7.jpg" title="Avatar" alt="Avatar"></li>
                        </ul>
                        <div class="progress-container l-black m-b-20">
                            <span class="progress-badge">Prograss</span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;">
                                    <span class="progress-value">39%</span>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-7">
                                <small>PROJECTS: 23</small>
                                <h6>BUDGET: 11,000 USD</h6>
                            </div>
                            <div class="col-5">
                                <div class="sparkline text-right m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#026466">6,3,1,5,8,7,3,4</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
@endsection
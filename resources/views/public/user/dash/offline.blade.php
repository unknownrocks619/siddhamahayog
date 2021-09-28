<div class='col-md-8'>
						<div class='card'>
							<div class='card-header'>
								<h4 class='card-title'>
									Offline Recording
									<span class='text-right font-weight-bold pt-1' style="font-size:12px;float:right">
										<a href="{{ route('public.offline.public_get_offline_videos') }}" class='border-bottom'>View All</a></span>
								</h4>
							</div>
							<div class='card-body'>
								@php
									$global_sessoin = \App\Models\ZoomSetting::where('is_global',true)
																				->where('is_active',true)
																				->count();
								@endphp	
								@if( $global_sessoin )
									<p class='text-danger'>
										Event you are associated is currently live. During the live session recorded view mode are automatically disabled.
									</p>
								@else
									@php
											$available_video_classes = \App\Models\OfflineVideo::where('is_active',true)
																	->with(['event_source'])
																	->latest()->limit(4)->get();
										@endphp
										@if ( ! $available_video_classes)
											<p class='text-info'>
												Oops ! No recording available.
											</p>
										@endif

										@if ( $available_video_classes )
											<ul class='list-group'>
												@foreach ($available_video_classes as $offline_videos)
													<li class="list-group-item">
														{{ $offline_videos->video_title }} 
														
														- 	<a data-target="#page-modal" data-toggle="modal" href="{{ route('modals.public_modal_display',['modal'=>'youtube_modal','reference'=>'Offline','reference_id'=>encrypt($offline_videos->id)]) }}" class='text-right btn btn-sm bg-info text-white'>
																<i class='fas fa-eye'></i>
																Watch Video
															</a>
													</li>
												@endforeach
											</ul>
										@endif
								@endif
							</div>
						</div>
					</div>
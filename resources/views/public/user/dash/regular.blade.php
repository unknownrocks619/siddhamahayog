	<!-- Public Events -->
    <div class='col-md-4'>
						<div class='card'>
							<div class='card-header'>
								<h4 class='card-title'>Regular Events</h4>
							</div>
							<div class='card-body' id="public_event_post_load">
								@if( ! $subscribed_class->count())
									@php
										$regular_event = \App\Models\SibirRecord::where('is_private',false)
																					->where('active',true)
																					->latest()
																					->paginate(3);
									@endphp
									<table class='table table-hover table-bordered'>
										<thead>
											<tr>
												<th>#</th>
												<th>Program Name</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach ($regular_event as $public_event)
												@if($public_event->event_class)
													<tr>
														<td>{{ $loop->index+1 }}</td>
														<td> {{ $public_event->sibir_title }} </td>
														<td>
															<a href="{{ $public_event->event_class->video_link }}" target="_blank" class='btn btn-primary btn-sm'>
																Join Session
															</a>
														</td>
													</tr>
												@endif
											@endforeach
										</tbody>
									</table>
								@endif

							</div>
						</div>
					</div>
<?php
$faq_info = array_shift($widget->fields);
?>
<section class="section">
    <div class="container">

        <div class="row align-items-center">
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset($faq_info->image->path) }}" class="w-100" alt="about">
            </div>

            <div class="col-lg-6">
                <div class="me-lg-30">
                    <div class="section-title section-title-2 text-start">
                        <h4 class="title">{{ $faq_info->title }}</h4>
                        <p>
                            {{ $faq_info->content }}
                        </p>
                    </div>
                    <div class="accordion with-gap" id="generalFAQExample">
                        @foreach ($widget->fields as $field)
                        <div class="card">
                            <div class="card-header collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#generalOne{{$loop->iteration}}" aria-expanded="false" aria-controls="generalOne{{$loop->iteration}}">
                                {{ $field->title }}
                            </div>

                            <div id="generalOne{{$loop->iteration}}" class="collapse" data-bs-parent="#generalFAQExample">
                                <div class="card-body">
                                    {{ $field->content }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
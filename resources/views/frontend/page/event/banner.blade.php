  <!-- partial:partia/__subheader.html -->
  <div class="sigma_subheader dark-overlay dark-overlay-2" style="background-image: url({{ bannner_image($event->page_image,'header') }})">

      <div class="container">
          <div class="sigma_subheader-inner">
              <div class="sigma_subheader-text">
                  <h1>{{ $event->event_title }}</h1>
              </div>
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a class="btn-link" href="{{ route('home') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="" class="btn-link">Events</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                          {{ $event->event_title }}
                      </li>
                  </ol>
              </nav>
          </div>
      </div>

  </div>
  <!-- partial -->